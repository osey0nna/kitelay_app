<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use App\Http\Requests\Juri\StorePenilaianRequest;
use App\Models\Pendaftaran;
use App\Models\Penilaian;
use App\Models\Perlombaan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PenilaianController extends Controller
{
    public function index(Request $request): View
    {
        $juri = $request->user();

        $perlombaans = $juri->lombaDinilai()
            ->withCount(['pendaftarans', 'kriterias'])
            ->latest()
            ->get();

        return view('juri.penilaian.index', [
            'perlombaans' => $perlombaans,
        ]);
    }

    public function submissions(Request $request, Perlombaan $perlombaan): View
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);

        $pendaftarans = $perlombaan->pendaftarans()
            ->with(['user'])
            ->withCount(['penilaians as scored_items_count' => fn ($query) => $query->where('user_id', $request->user()->id)])
            ->latest()
            ->get();

        return view('juri.penilaian.submissions', [
            'perlombaan' => $perlombaan,
            'pendaftarans' => $pendaftarans,
        ]);
    }

    public function results(Request $request, Perlombaan $perlombaan): View|RedirectResponse
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);

        if (! $perlombaan->resultsAreVisible()) {
            return redirect()
                ->route('juri.penilaian.submissions', $perlombaan)
                ->with('status', 'Hasil lomba belum dipublikasikan admin atau jadwal pengumumannya belum tiba.');
        }

        $rankedRegistrations = Pendaftaran::query()
            ->with('user')
            ->where('perlombaan_id', $perlombaan->id)
            ->whereNotNull('final_score')
            ->orderByDesc('final_score')
            ->orderBy('submitted_at')
            ->get()
            ->values()
            ->map(function ($registration, $index) {
                $registration->ranking_position = $index + 1;

                return $registration;
            });

        return view('juri.penilaian.results', [
            'perlombaan' => $perlombaan,
            'rankedRegistrations' => $rankedRegistrations,
            'podium' => $rankedRegistrations->take(3),
        ]);
    }

    public function edit(Request $request, Perlombaan $perlombaan, Pendaftaran $pendaftaran): View
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);
        $this->ensureSubmissionBelongsToCompetition($perlombaan, $pendaftaran);

        $perlombaan->load('kriterias');
        $existingScores = $pendaftaran->penilaians()
            ->where('user_id', $request->user()->id)
            ->get()
            ->keyBy('kriteria_id');

        return view('juri.penilaian.edit', [
            'perlombaan' => $perlombaan,
            'pendaftaran' => $pendaftaran->load('user'),
            'existingScores' => $existingScores,
        ]);
    }

    public function showSubmissionFile(Request $request, Perlombaan $perlombaan, Pendaftaran $pendaftaran): StreamedResponse
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);
        $this->ensureSubmissionBelongsToCompetition($perlombaan, $pendaftaran);

        return $this->streamSubmissionFile($pendaftaran, false);
    }

    public function downloadSubmissionFile(Request $request, Perlombaan $perlombaan, Pendaftaran $pendaftaran): StreamedResponse
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);
        $this->ensureSubmissionBelongsToCompetition($perlombaan, $pendaftaran);

        return $this->streamSubmissionFile($pendaftaran, true);
    }

    public function update(StorePenilaianRequest $request, Perlombaan $perlombaan, Pendaftaran $pendaftaran): RedirectResponse
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);
        $this->ensureSubmissionBelongsToCompetition($perlombaan, $pendaftaran);

        $perlombaan->load('kriterias');
        $validKriteriaIds = $perlombaan->kriterias
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        DB::transaction(function () use ($request, $pendaftaran, $perlombaan, $validKriteriaIds) {
            foreach ($request->validated('scores') as $scoreData) {
                $kriteriaId = (int) $scoreData['kriteria_id'];
                $skor = (int) $scoreData['skor'];

                abort_unless(in_array($kriteriaId, $validKriteriaIds, true), 422);

                Penilaian::updateOrCreate(
                    [
                        'pendaftaran_id' => $pendaftaran->id,
                        'user_id' => $request->user()->id,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'skor' => $skor,
                        'catatan' => $scoreData['catatan'] ?? null,
                    ]
                );
            }

            $pendaftaran->refreshScoreState();
        });

        return redirect()
            ->route('juri.penilaian.submissions', $perlombaan)
            ->with('status', 'Penilaian peserta berhasil disimpan.');
    }

    protected function ensureAssigned(int $userId, Perlombaan $perlombaan): void
    {
        abort_unless($perlombaan->juris()->where('users.id', $userId)->exists(), 403);
    }

    protected function ensureSubmissionBelongsToCompetition(Perlombaan $perlombaan, Pendaftaran $pendaftaran): void
    {
        abort_unless($pendaftaran->perlombaan_id === $perlombaan->id, 404);
    }

    protected function streamSubmissionFile(Pendaftaran $pendaftaran, bool $download): StreamedResponse
    {
        abort_unless($pendaftaran->hasStoredSubmissionFile(), 404);

        $disk = Storage::disk(Pendaftaran::submissionDisk());
        abort_unless($disk->exists($pendaftaran->file_hasil), 404);

        return $download
            ? $disk->download($pendaftaran->file_hasil, $pendaftaran->submission_file_name)
            : $disk->response($pendaftaran->file_hasil, $pendaftaran->submission_file_name);
    }
}
