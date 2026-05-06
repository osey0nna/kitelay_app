<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perlombaan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HasilPerlombaanController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCompetition = null;

        if ($request->filled('perlombaan')) {
            $selectedCompetition = Perlombaan::query()->findOrFail($request->integer('perlombaan'));
        }

        return $this->renderPage($selectedCompetition);
    }

    public function show(Perlombaan $perlombaan): View
    {
        return $this->renderPage($perlombaan);
    }

    public function publish(Perlombaan $perlombaan): RedirectResponse
    {
        $hasResults = $perlombaan->pendaftarans()->whereNotNull('final_score')->exists();

        if (! $hasResults) {
            return redirect()
                ->route('admin.perlombaan.hasil.show', $perlombaan)
                ->with('status', 'Hasil belum bisa dipublikasikan karena belum ada nilai final peserta.');
        }

        $perlombaan->update([
            'status' => Perlombaan::STATUS_FINISHED,
            'results_released_at' => $perlombaan->results_released_at ?? now(),
            'results_published_at' => now(),
        ]);

        $message = $perlombaan->announcement_at !== null && $perlombaan->announcement_at->isFuture()
            ? 'Hasil berhasil dipublikasikan oleh admin. Hasil akan tetap baru terlihat saat jadwal pengumuman tiba.'
            : 'Hasil berhasil dipublikasikan dan sekarang bisa dilihat sesuai aturan publikasi.';

        return redirect()
            ->route('admin.perlombaan.hasil.show', $perlombaan)
            ->with('status', $message);
    }

    public function unpublish(Perlombaan $perlombaan): RedirectResponse
    {
        $perlombaan->update([
            'results_published_at' => null,
        ]);

        return redirect()
            ->route('admin.perlombaan.hasil.show', $perlombaan)
            ->with('status', 'Publikasi publik berhasil ditutup. Peserta dan juri tetap bisa melihat hasil sebagai riwayat, tetapi halaman publik disembunyikan.');
    }

    protected function renderPage(?Perlombaan $perlombaan): View
    {
        $competitions = Perlombaan::query()
            ->withCount(['pendaftarans', 'kriterias', 'juris'])
            ->latest()
            ->get();

        $registrations = collect();
        $rankedRegistrations = collect();
        $podium = collect();
        $averageScore = 0;

        if ($perlombaan) {
            $perlombaan->loadCount(['pendaftarans', 'kriterias', 'juris']);

            $registrations = $perlombaan->pendaftarans()
            ->with([
                'user',
                'penilaians.kriteria',
                'penilaians.juri',
            ])
            ->orderByDesc('final_score')
            ->orderBy('submitted_at')
            ->get();

            $rankedRegistrations = $registrations
                ->filter(fn ($registration) => $registration->final_score !== null)
                ->values()
                ->map(function ($registration, $index) {
                    $registration->ranking_position = $index + 1;

                    return $registration;
                });

            $podium = $rankedRegistrations->take(3);
            $averageScore = round((float) $rankedRegistrations->avg('final_score'), 2);
        }

        return view('admin.hasil.show', [
            'perlombaan' => $perlombaan,
            'competitions' => $competitions,
            'registrations' => $registrations,
            'rankedRegistrations' => $rankedRegistrations,
            'podium' => $podium,
            'averageScore' => $averageScore,
        ]);
    }
}
