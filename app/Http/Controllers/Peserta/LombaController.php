<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Peserta\UpdateSubmissionRequest;
use App\Models\Pendaftaran;
use App\Models\Perlombaan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LombaController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $availableCompetitions = Perlombaan::query()
            ->with(['juris:id,name'])
            ->withCount(['kriterias', 'juris', 'pendaftarans'])
            ->whereIn('status', [
                Perlombaan::STATUS_PUBLISHED,
                Perlombaan::STATUS_REGISTRATION_OPEN,
                Perlombaan::STATUS_ONGOING,
            ])
            ->latest()
            ->get();

        $myRegistrations = Pendaftaran::query()
            ->with(['perlombaan'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $registeredCompetitionIds = $myRegistrations->pluck('perlombaan_id')->all();

        return view('peserta.lomba.index', [
            'availableCompetitions' => $availableCompetitions,
            'myRegistrations' => $myRegistrations,
            'registeredCompetitionIds' => $registeredCompetitionIds,
        ]);
    }

    public function show(Request $request, Perlombaan $perlombaan): View
    {
        abort_unless($this->canRegisterToCompetition($perlombaan), 403);

        $request->session()->put($this->detailViewedSessionKey($perlombaan), true);

        $perlombaan->load(['kriterias', 'juris:id,name'])->loadCount(['pendaftarans', 'kriterias', 'juris']);

        $existingRegistration = Pendaftaran::query()
            ->where('user_id', $request->user()->id)
            ->where('perlombaan_id', $perlombaan->id)
            ->first();

        $rundown = collect([
            [
                'label' => 'Pendaftaran Dibuka',
                'datetime' => $perlombaan->registration_start_at,
                'description' => 'Peserta mulai bisa mempelajari detail lomba dan mengamankan slot pendaftaran.',
            ],
            [
                'label' => 'Pendaftaran Ditutup',
                'datetime' => $perlombaan->registration_end_at ?? $perlombaan->deadline_pendaftaran,
                'description' => 'Batas akhir peserta mendaftarkan diri ke lomba ini.',
            ],
            [
                'label' => 'Batas Submission',
                'datetime' => $perlombaan->submission_deadline_at,
                'description' => 'Karya final harus sudah diunggah sebelum tahap penjurian dimulai.',
            ],
            [
                'label' => 'Pengumuman Hasil',
                'datetime' => $perlombaan->announcement_at,
                'description' => 'Podium dan hasil resmi dibuka sesuai jadwal pengumuman yang ditetapkan admin.',
            ],
        ])->filter(fn (array $item) => $item['datetime'] !== null)->values();

        return view('peserta.lomba.show', [
            'perlombaan' => $perlombaan,
            'existingRegistration' => $existingRegistration,
            'rundown' => $rundown,
            'participantsRemaining' => $perlombaan->max_participants === null
                ? null
                : max($perlombaan->max_participants - $perlombaan->pendaftarans_count, 0),
        ]);
    }

    public function register(Request $request, Perlombaan $perlombaan): RedirectResponse
    {
        abort_unless($this->canRegisterToCompetition($perlombaan), 403);

        if (! $request->session()->pull($this->detailViewedSessionKey($perlombaan), false)) {
            return redirect()
                ->route('peserta.lomba.show', $perlombaan)
                ->with('status', 'Silakan baca detail lomba dan rundown lengkap terlebih dahulu sebelum mendaftar.');
        }

        if ($perlombaan->max_participants !== null && $perlombaan->pendaftarans()->count() >= $perlombaan->max_participants) {
            return redirect()
                ->route('peserta.lomba.show', $perlombaan)
                ->with('status', 'Kuota perlombaan ini sudah penuh.');
        }

        Pendaftaran::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'perlombaan_id' => $perlombaan->id,
            ],
            [
                'status' => Pendaftaran::STATUS_REGISTERED,
            ]
        );

        return redirect()
            ->route('peserta.lomba.index')
            ->with('status', "Kamu berhasil mendaftar ke {$perlombaan->nama_lomba}.");
    }

    public function edit(Pendaftaran $pendaftaran, Request $request): View
    {
        $this->ensureOwnedByUser($pendaftaran, $request->user()->id);

        return view('peserta.lomba.edit', [
            'pendaftaran' => $pendaftaran->load('perlombaan'),
        ]);
    }

    public function update(UpdateSubmissionRequest $request, Pendaftaran $pendaftaran): RedirectResponse
    {
        $this->ensureOwnedByUser($pendaftaran, $request->user()->id);

        $attributes = [
            'submission_title' => $request->validated('submission_title'),
            'submission_notes' => $request->validated('submission_notes'),
            'submitted_at' => now(),
            'status' => Pendaftaran::STATUS_SUBMITTED,
        ];

        if ($request->hasFile('file_hasil')) {
            if (filled($pendaftaran->file_hasil) && str_starts_with($pendaftaran->file_hasil, 'submissions/')) {
                Storage::disk(Pendaftaran::submissionDisk())->delete($pendaftaran->file_hasil);
            }

            $storedPath = $this->storeSubmissionFile($request->file('file_hasil'));

            if ($storedPath === null) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'file_hasil' => 'File gagal diproses. Coba upload ulang, ganti nama file tanpa karakter aneh, atau kompres file desain ke ZIP/RAR terlebih dulu.',
                    ]);
            }

            $attributes['file_hasil'] = $storedPath;
        }

        $pendaftaran->update($attributes);

        return redirect()
            ->route('peserta.lomba.index')
            ->with('status', 'Submission berhasil disimpan.');
    }

    public function results(Pendaftaran $pendaftaran, Request $request): View|RedirectResponse
    {
        $this->ensureOwnedByUser($pendaftaran, $request->user()->id);

        $pendaftaran->load('perlombaan', 'user');

        if (! $pendaftaran->perlombaan->resultsAreVisible()) {
            return redirect()
                ->route('peserta.lomba.index')
                ->with('status', 'Hasil lomba belum dipublikasikan. Silakan tunggu sampai tanggal pengumuman tiba.');
        }

        $rankedRegistrations = Pendaftaran::query()
            ->with('user')
            ->where('perlombaan_id', $pendaftaran->perlombaan_id)
            ->whereNotNull('final_score')
            ->orderByDesc('final_score')
            ->orderBy('submitted_at')
            ->get()
            ->values()
            ->map(function ($registration, $index) {
                $registration->ranking_position = $index + 1;

                return $registration;
            });

        return view('peserta.lomba.results', [
            'pendaftaran' => $pendaftaran,
            'rankedRegistrations' => $rankedRegistrations,
            'myRanking' => $rankedRegistrations->firstWhere('id', $pendaftaran->id),
            'podium' => $rankedRegistrations->take(3),
        ]);
    }

    protected function ensureOwnedByUser(Pendaftaran $pendaftaran, int $userId): void
    {
        abort_unless($pendaftaran->user_id === $userId, 403);
    }

    protected function canRegisterToCompetition(Perlombaan $perlombaan): bool
    {
        return in_array($perlombaan->status, [
            Perlombaan::STATUS_PUBLISHED,
            Perlombaan::STATUS_REGISTRATION_OPEN,
            Perlombaan::STATUS_ONGOING,
        ], true);
    }

    protected function detailViewedSessionKey(Perlombaan $perlombaan): string
    {
        return 'peserta.viewed_competition_detail.'.$perlombaan->id;
    }

    protected function storeSubmissionFile(UploadedFile $file): ?string
    {
        if (! $file->isValid()) {
            return null;
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin');
        $filename = Str::uuid()->toString().'.'.$extension;
        $targetPath = 'submissions/'.$filename;
        $sourcePath = $file->getPathname();

        if (! filled($sourcePath) || ! is_file($sourcePath)) {
            return null;
        }

        $stream = fopen($sourcePath, 'r');

        if ($stream === false) {
            return null;
        }

        try {
            Storage::disk(Pendaftaran::submissionDisk())->put($targetPath, $stream);
        } finally {
            fclose($stream);
        }

        return $targetPath;
    }
}
