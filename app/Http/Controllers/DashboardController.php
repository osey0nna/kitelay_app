<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Penilaian;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $stats = match ($user->role) {
            'admin' => $this->adminStats(),
            'juri' => $this->juriStats($user->id),
            default => $this->pendaftarStats($user->id),
        };

        return view('dashboard', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    protected function adminStats(): array
    {
        $latestCompetitions = Perlombaan::query()
            ->withCount(['kriterias', 'pendaftarans', 'juris'])
            ->latest()
            ->take(5)
            ->get();

        $recentRegistrations = Pendaftaran::query()
            ->with(['user', 'perlombaan'])
            ->latest()
            ->take(5)
            ->get();

        return [
            'hero' => [
                'badge' => 'Admin Control Center',
                'title' => 'Pantau performa sistem lomba, assignment juri, dan progres penilaian dari satu dashboard.',
                'description' => 'Dashboard admin sekarang difokuskan untuk monitoring cepat: status lomba, beban review, aktivitas user, dan jalur aksi penting yang paling sering dipakai.',
                'accent' => 'sky',
                'summary' => 'Akses penuh untuk user, lomba, kriteria, assignment juri, hasil, dan publikasi pengumuman.',
            ],
            'metrics' => [
                ['label' => 'Total Perlombaan', 'value' => Perlombaan::count(), 'tone' => 'sky', 'helper' => 'Semua status lomba'],
                ['label' => 'Total User', 'value' => User::count(), 'tone' => 'emerald', 'helper' => 'Admin, juri, dan pendaftar'],
                ['label' => 'Perlu Review', 'value' => Pendaftaran::query()->where('status', Pendaftaran::STATUS_SUBMITTED)->count(), 'tone' => 'orange', 'helper' => 'Submission menunggu penilaian'],
                ['label' => 'Nilai Masuk', 'value' => Penilaian::count(), 'tone' => 'slate', 'helper' => 'Seluruh input skor juri'],
            ],
            'quickActions' => [
                ['label' => 'Kelola User', 'href' => route('admin.users.index'), 'description' => 'Buat akun juri atau rapikan role user.', 'tone' => 'sky'],
                ['label' => 'Kelola Perlombaan', 'href' => route('admin.perlombaan.index'), 'description' => 'Tambah lomba, kriteria, dan assignment juri.', 'tone' => 'orange'],
                ['label' => 'Pengumuman Publik', 'href' => route('pengumuman.index'), 'description' => 'Cek apa yang sudah tampil ke publik.', 'tone' => 'emerald'],
            ],
            'statusCards' => [
                ['label' => 'Pendaftaran Dibuka', 'value' => Perlombaan::query()->where('status', Perlombaan::STATUS_REGISTRATION_OPEN)->count(), 'tone' => 'sky'],
                ['label' => 'Sedang Dinilai', 'value' => Perlombaan::query()->where('status', Perlombaan::STATUS_JUDGING)->count(), 'tone' => 'orange'],
                ['label' => 'Selesai', 'value' => Perlombaan::query()->where('status', Perlombaan::STATUS_FINISHED)->count(), 'tone' => 'emerald'],
                ['label' => 'Sudah Dinilai', 'value' => Pendaftaran::query()->where('status', Pendaftaran::STATUS_REVIEWED)->count(), 'tone' => 'slate'],
            ],
            'primaryList' => [
                'eyebrow' => 'Perlombaan Terbaru',
                'title' => 'Item yang paling sering perlu dipantau admin.',
                'empty' => 'Belum ada perlombaan di sistem.',
                'items' => $latestCompetitions->map(fn (Perlombaan $perlombaan) => [
                    'title' => $perlombaan->nama_lomba,
                    'description' => $perlombaan->deskripsi,
                    'meta' => "Peserta {$perlombaan->pendaftarans_count} | Kriteria {$perlombaan->kriterias_count} | Juri {$perlombaan->juris_count}",
                    'badge' => str($perlombaan->status)->replace('_', ' ')->title()->toString(),
                    'href' => route('admin.perlombaan.edit', $perlombaan),
                    'link_label' => 'Buka Lomba',
                ])->all(),
            ],
            'secondaryList' => [
                'eyebrow' => 'Aktivitas Terbaru',
                'title' => 'Pendaftaran terakhir yang masuk ke sistem.',
                'empty' => 'Belum ada aktivitas pendaftaran.',
                'items' => $recentRegistrations->map(fn (Pendaftaran $registration) => [
                    'title' => $registration->user->name,
                    'description' => $registration->perlombaan->nama_lomba,
                    'meta' => $registration->created_at?->translatedFormat('d M Y H:i') ?? '-',
                    'badge' => str($registration->status)->replace('_', ' ')->title()->toString(),
                    'href' => route('admin.perlombaan.hasil.show', $registration->perlombaan),
                    'link_label' => 'Lihat Hasil',
                ])->all(),
            ],
        ];
    }

    protected function juriStats(int $userId): array
    {
        $assignedCompetitions = Perlombaan::query()
            ->whereHas('juris', fn ($query) => $query->where('users.id', $userId))
            ->withCount(['pendaftarans', 'kriterias'])
            ->latest()
            ->get();
        $publishedResults = $assignedCompetitions->filter(fn (Perlombaan $perlombaan) => $perlombaan->resultsAreVisible());

        $submissionsToReview = Pendaftaran::query()
            ->whereHas('perlombaan.juris', fn ($query) => $query->where('users.id', $userId))
            ->where('status', Pendaftaran::STATUS_SUBMITTED)
            ->count();

        $scoresGiven = Penilaian::query()->where('user_id', $userId)->count();
        $reviewedSubmissions = Penilaian::query()
            ->where('user_id', $userId)
            ->distinct('pendaftaran_id')
            ->count('pendaftaran_id');
        $recentScores = Penilaian::query()
            ->with(['pendaftaran.user', 'pendaftaran.perlombaan', 'kriteria'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();
        $firstCompetition = $assignedCompetitions->first();
        $firstPublishedResult = $publishedResults->first();

        return [
            'hero' => [
                'badge' => 'Juri Workspace',
                'title' => 'Fokus menilai submission yang memang menjadi tanggung jawabmu.',
                'description' => 'Dashboard juri menampilkan jumlah submission menunggu review, progres penilaian, akses tercepat ke lomba tugas, dan hasil final yang sudah dipublikasikan admin.',
                'accent' => 'orange',
                'summary' => 'Juri menilai lomba yang di-assign admin, lalu bisa melihat podium setelah hasil resmi dipublikasikan.',
            ],
            'metrics' => [
                ['label' => 'Lomba Ditugaskan', 'value' => $assignedCompetitions->count(), 'tone' => 'orange', 'helper' => 'Area kerja aktif juri'],
                ['label' => 'Menunggu Review', 'value' => $submissionsToReview, 'tone' => 'sky', 'helper' => 'Submission status submitted'],
                ['label' => 'Peserta Dinilai', 'value' => $reviewedSubmissions, 'tone' => 'emerald', 'helper' => 'Submission yang sudah disentuh'],
                ['label' => 'Hasil Terbuka', 'value' => $publishedResults->count(), 'tone' => 'slate', 'helper' => 'Podium yang sudah dipublikasikan'],
            ],
            'quickActions' => [
                ['label' => 'Daftar Lomba Juri', 'href' => route('juri.penilaian.index'), 'description' => 'Buka semua lomba yang di-assign ke kamu.', 'tone' => 'orange'],
                ['label' => 'Submission Pertama', 'href' => $firstCompetition ? route('juri.penilaian.submissions', $firstCompetition) : route('juri.penilaian.index'), 'description' => 'Langsung masuk ke antrean penilaian.', 'tone' => 'sky'],
                ['label' => 'Hasil Terbaru', 'href' => $firstPublishedResult ? route('juri.penilaian.results', $firstPublishedResult) : route('juri.penilaian.index'), 'description' => 'Lihat podium lomba yang sudah diumumkan.', 'tone' => 'emerald'],
            ],
            'statusCards' => [
                ['label' => 'Status Submitted', 'value' => $submissionsToReview, 'tone' => 'orange'],
                ['label' => 'Status Reviewed', 'value' => Pendaftaran::query()->whereHas('penilaians', fn ($query) => $query->where('user_id', $userId))->distinct('id')->count('id'), 'tone' => 'emerald'],
                ['label' => 'Lomba Berjalan', 'value' => $assignedCompetitions->whereIn('status', [Perlombaan::STATUS_ONGOING, Perlombaan::STATUS_JUDGING])->count(), 'tone' => 'sky'],
                ['label' => 'Podium Terbuka', 'value' => $publishedResults->count(), 'tone' => 'slate'],
            ],
            'primaryList' => [
                'eyebrow' => 'Lomba Tugas',
                'title' => 'Ringkasan lomba yang sedang kamu pegang.',
                'empty' => 'Belum ada lomba yang di-assign ke akun juri ini.',
                'items' => $assignedCompetitions->map(function (Perlombaan $perlombaan) {
                    $resultsVisible = $perlombaan->resultsAreVisible();

                    return [
                        'title' => $perlombaan->nama_lomba,
                        'description' => \Illuminate\Support\Str::limit($perlombaan->deskripsi, 110),
                        'meta' => "Peserta {$perlombaan->pendaftarans_count} | Kriteria {$perlombaan->kriterias_count}",
                        'badge' => $resultsVisible ? 'Hasil Dibuka' : str($perlombaan->status)->replace('_', ' ')->title()->toString(),
                        'href' => $resultsVisible
                            ? route('juri.penilaian.results', $perlombaan)
                            : route('juri.penilaian.submissions', $perlombaan),
                        'link_label' => $resultsVisible ? 'Lihat Podium' : 'Buka Submission',
                    ];
                })->all(),
            ],
            'secondaryList' => [
                'eyebrow' => 'Skor Terbaru',
                'title' => 'Riwayat input nilai yang paling baru.',
                'empty' => 'Belum ada nilai yang kamu input.',
                'items' => $recentScores->map(fn (Penilaian $penilaian) => [
                    'title' => $penilaian->pendaftaran->user->name,
                    'description' => "{$penilaian->pendaftaran->perlombaan->nama_lomba} | {$penilaian->kriteria->nama_kriteria}",
                    'meta' => "Skor {$penilaian->skor} | ".$penilaian->created_at?->translatedFormat('d M Y H:i'),
                    'badge' => 'Tersimpan',
                    'href' => route('juri.penilaian.edit', [$penilaian->pendaftaran->perlombaan, $penilaian->pendaftaran]),
                    'link_label' => 'Review Nilai',
                ])->all(),
            ],
        ];
    }

    protected function pendaftarStats(int $userId): array
    {
        $registrations = Pendaftaran::query()
            ->with('perlombaan')
            ->where('user_id', $userId)
            ->latest()
            ->get();
        $visibleResultRegistrations = $registrations->filter(
            fn (Pendaftaran $registration) => $registration->status === Pendaftaran::STATUS_REVIEWED
                && $registration->perlombaan->resultsAreVisible()
        );
        $availableCompetitions = Perlombaan::query()
            ->whereIn('status', [
                Perlombaan::STATUS_PUBLISHED,
                Perlombaan::STATUS_REGISTRATION_OPEN,
                Perlombaan::STATUS_ONGOING,
            ])
            ->withCount(['kriterias', 'juris'])
            ->latest()
            ->take(5)
            ->get();
        $latestRegistration = $registrations->first();

        return [
            'hero' => [
                'badge' => 'Peserta Dashboard',
                'title' => 'Pantau semua progres lombamu dari daftar sampai pengumuman nilai.',
                'description' => 'Dashboard peserta menampilkan peluang lomba yang masih terbuka, status submission, dan hasil akhir saat penjurian selesai.',
                'accent' => 'emerald',
                'summary' => 'Peserta bisa daftar lomba, upload karya, melihat skor akhir, ranking, dan podium.',
            ],
            'metrics' => [
                ['label' => 'Lomba Tersedia', 'value' => $availableCompetitions->count(), 'tone' => 'sky', 'helper' => 'Siap didaftari sekarang'],
                ['label' => 'Lomba Diikuti', 'value' => $registrations->count(), 'tone' => 'emerald', 'helper' => 'Total pendaftaran kamu'],
                ['label' => 'Sudah Submit', 'value' => $registrations->whereIn('status', [Pendaftaran::STATUS_SUBMITTED, Pendaftaran::STATUS_REVIEWED])->count(), 'tone' => 'orange', 'helper' => 'Karya sudah masuk ke sistem'],
                ['label' => 'Hasil Terbuka', 'value' => $visibleResultRegistrations->count(), 'tone' => 'slate', 'helper' => 'Sudah melewati jadwal pengumuman'],
            ],
            'quickActions' => [
                ['label' => 'Lihat Katalog Lomba', 'href' => route('peserta.lomba.index'), 'description' => 'Buka semua lomba yang masih tersedia.', 'tone' => 'emerald'],
                ['label' => 'Submission Terakhir', 'href' => $latestRegistration ? route('peserta.lomba.edit', $latestRegistration) : route('peserta.lomba.index'), 'description' => 'Lanjutkan pengisian submission terakhirmu.', 'tone' => 'orange'],
                ['label' => 'Profile', 'href' => route('profile.edit'), 'description' => 'Perbarui identitas dan akun peserta.', 'tone' => 'sky'],
            ],
            'statusCards' => [
                ['label' => 'Registered', 'value' => $registrations->where('status', Pendaftaran::STATUS_REGISTERED)->count(), 'tone' => 'sky'],
                ['label' => 'Submitted', 'value' => $registrations->where('status', Pendaftaran::STATUS_SUBMITTED)->count(), 'tone' => 'orange'],
                ['label' => 'Reviewed', 'value' => $registrations->where('status', Pendaftaran::STATUS_REVIEWED)->count(), 'tone' => 'emerald'],
                ['label' => 'Diskualifikasi', 'value' => $registrations->where('status', Pendaftaran::STATUS_DISQUALIFIED)->count(), 'tone' => 'slate'],
            ],
            'primaryList' => [
                'eyebrow' => 'Lomba Saya',
                'title' => 'Progress terbaru dari lomba yang kamu ikuti.',
                'empty' => 'Kamu belum punya pendaftaran lomba.',
                'items' => $registrations->take(5)->map(function (Pendaftaran $registration) {
                    $resultsVisible = $registration->final_score !== null && $registration->perlombaan->resultsAreVisible();

                    return [
                        'title' => $registration->perlombaan->nama_lomba,
                        'description' => $registration->submission_title ?: 'Belum ada judul submission',
                        'meta' => $registration->submitted_at?->translatedFormat('d M Y H:i') ?? 'Belum submit',
                        'badge' => str($registration->status)->replace('_', ' ')->title()->toString(),
                        'href' => $resultsVisible
                            ? route('peserta.lomba.results', $registration)
                            : route('peserta.lomba.edit', $registration),
                        'link_label' => $resultsVisible
                            ? 'Lihat Hasil'
                            : ($registration->submitted_at ? 'Lihat Submission' : 'Lengkapi Submission'),
                    ];
                })->all(),
            ],
            'secondaryList' => [
                'eyebrow' => 'Peluang Baru',
                'title' => 'Lomba yang masih menarik untuk diikuti.',
                'empty' => 'Belum ada lomba baru yang tersedia.',
                'items' => $availableCompetitions->map(fn (Perlombaan $perlombaan) => [
                    'title' => $perlombaan->nama_lomba,
                    'description' => \Illuminate\Support\Str::limit($perlombaan->deskripsi, 110),
                    'meta' => "Kriteria {$perlombaan->kriterias_count} | Juri {$perlombaan->juris_count}",
                    'badge' => str($perlombaan->status)->replace('_', ' ')->title()->toString(),
                    'href' => route('peserta.lomba.index'),
                    'link_label' => 'Buka Katalog',
                ])->all(),
            ],
        ];
    }
}
