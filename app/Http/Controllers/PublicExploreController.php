<?php

namespace App\Http\Controllers;

use App\Models\Perlombaan;
use Illuminate\Contracts\View\View;

class PublicExploreController extends Controller
{
    public function index(): View
    {
        $baseQuery = Perlombaan::query()
            ->withCount(['pendaftarans', 'kriterias', 'juris'])
            ->whereIn('status', [
                Perlombaan::STATUS_PUBLISHED,
                Perlombaan::STATUS_REGISTRATION_OPEN,
                Perlombaan::STATUS_ONGOING,
                Perlombaan::STATUS_JUDGING,
                Perlombaan::STATUS_FINISHED,
            ])
            ->latest();

        return view('public.explore.index', [
            'availableCompetitions' => (clone $baseQuery)
                ->whereIn('status', [
                    Perlombaan::STATUS_PUBLISHED,
                    Perlombaan::STATUS_REGISTRATION_OPEN,
                ])
                ->get(),
            'ongoingCompetitions' => (clone $baseQuery)
                ->whereIn('status', [
                    Perlombaan::STATUS_ONGOING,
                    Perlombaan::STATUS_JUDGING,
                ])
                ->get(),
            'pastCompetitions' => (clone $baseQuery)
                ->where('status', Perlombaan::STATUS_FINISHED)
                ->get(),
            'publishedAnnouncementsCount' => Perlombaan::query()
                ->whereNotNull('results_published_at')
                ->where(function ($query) {
                    $query->whereNull('announcement_at')
                        ->orWhere('announcement_at', '<=', now());
                })
                ->count(),
        ]);
    }
}
