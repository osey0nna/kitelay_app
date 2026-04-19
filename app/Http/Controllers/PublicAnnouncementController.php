<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Perlombaan;
use Illuminate\Contracts\View\View;

class PublicAnnouncementController extends Controller
{
    public function index(): View
    {
        $competitions = Perlombaan::query()
            ->withCount(['pendaftarans', 'kriterias', 'juris'])
            ->whereNotNull('results_published_at')
            ->where(function ($query) {
                $query->whereNull('announcement_at')
                    ->orWhere('announcement_at', '<=', now());
            })
            ->latest()
            ->get();

        return view('public.announcements.index', [
            'competitions' => $competitions,
        ]);
    }

    public function show(Perlombaan $perlombaan): View
    {
        abort_unless($perlombaan->resultsArePubliclyVisible(), 404);

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

        return view('public.announcements.show', [
            'perlombaan' => $perlombaan,
            'rankedRegistrations' => $rankedRegistrations,
            'podium' => $rankedRegistrations->take(3),
        ]);
    }
}
