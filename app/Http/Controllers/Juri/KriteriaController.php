<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use App\Http\Requests\Juri\UpdateKriteriaRequest;
use App\Models\Kriteria;
use App\Models\Perlombaan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index(Request $request, Perlombaan $perlombaan): View
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);

        $kriterias = $perlombaan->kriterias()->get();

        return view('juri.kriteria.index', [
            'perlombaan' => $perlombaan,
            'kriterias' => $kriterias,
            'totalBobot' => $kriterias->sum('bobot'),
        ]);
    }

    public function edit(Request $request, Perlombaan $perlombaan, Kriteria $kriteria): View
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);
        $this->ensureBelongsToCompetition($perlombaan, $kriteria);

        return view('juri.kriteria.edit', [
            'perlombaan' => $perlombaan,
            'kriteria' => $kriteria,
        ]);
    }

    public function update(UpdateKriteriaRequest $request, Perlombaan $perlombaan, Kriteria $kriteria): RedirectResponse
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);
        $this->ensureBelongsToCompetition($perlombaan, $kriteria);

        $kriteria->update($request->validated());

        return redirect()
            ->route('juri.kriteria.index', $perlombaan)
            ->with('status', 'Kriteria berhasil diperbarui dari workspace juri.');
    }

    public function destroy(Request $request, Perlombaan $perlombaan, Kriteria $kriteria): RedirectResponse
    {
        $this->ensureAssigned($request->user()->id, $perlombaan);
        $this->ensureBelongsToCompetition($perlombaan, $kriteria);

        $kriteria->deleteAndRefreshScores();

        return redirect()
            ->route('juri.kriteria.index', $perlombaan)
            ->with('status', 'Kriteria berhasil dihapus dari workspace juri.');
    }

    protected function ensureAssigned(int $userId, Perlombaan $perlombaan): void
    {
        abort_unless($perlombaan->juris()->where('users.id', $userId)->exists(), 403);
    }

    protected function ensureBelongsToCompetition(Perlombaan $perlombaan, Kriteria $kriteria): void
    {
        abort_unless($kriteria->perlombaan_id === $perlombaan->id, 404);
    }
}
