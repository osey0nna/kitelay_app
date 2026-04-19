<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SyncJuriRequest;
use App\Models\Pendaftaran;
use App\Models\Penilaian;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class JuriAssignmentController extends Controller
{
    public function index(Perlombaan $perlombaan): View
    {
        $availableJuries = User::query()
            ->where('role', User::ROLE_JURI)
            ->withCount('lombaDinilai')
            ->orderBy('name')
            ->get();

        return view('admin.juri-assignment.index', [
            'perlombaan' => $perlombaan,
            'availableJuries' => $availableJuries,
            'assignedIds' => $perlombaan->juris()->pluck('users.id')->all(),
        ]);
    }

    public function update(SyncJuriRequest $request, Perlombaan $perlombaan): RedirectResponse
    {
        $newJuriIds = collect($request->validated('juri_ids', []))
            ->map(fn ($id) => (int) $id)
            ->all();
        $currentJuriIds = $perlombaan->juris()->pluck('users.id');
        $removedJuriIds = $currentJuriIds->diff($newJuriIds)->values();

        DB::transaction(function () use ($perlombaan, $newJuriIds, $removedJuriIds) {
            $affectedPendaftaranIds = collect();

            if ($removedJuriIds->isNotEmpty()) {
                $competitionRegistrationIds = $perlombaan->pendaftarans()->pluck('id');

                if ($competitionRegistrationIds->isNotEmpty()) {
                    $affectedPendaftaranIds = Penilaian::query()
                        ->whereIn('user_id', $removedJuriIds)
                        ->whereIn('pendaftaran_id', $competitionRegistrationIds)
                        ->select('pendaftaran_id')
                        ->distinct()
                        ->pluck('pendaftaran_id');

                    Penilaian::query()
                        ->whereIn('user_id', $removedJuriIds)
                        ->whereIn('pendaftaran_id', $competitionRegistrationIds)
                        ->delete();
                }
            }

            $perlombaan->juris()->sync($newJuriIds);

            if ($affectedPendaftaranIds->isNotEmpty()) {
                Pendaftaran::query()
                    ->whereIn('id', $affectedPendaftaranIds)
                    ->get()
                    ->each(fn (Pendaftaran $pendaftaran) => $pendaftaran->refreshScoreState());
            }
        });

        return redirect()
            ->route('admin.perlombaan.juri.index', $perlombaan)
            ->with('status', 'Assignment juri berhasil diperbarui.');
    }
}
