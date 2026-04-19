<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKriteriaRequest;
use App\Http\Requests\Admin\UpdateKriteriaRequest;
use App\Models\Kriteria;
use App\Models\Perlombaan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class KriteriaController extends Controller
{
    public function index(Perlombaan $perlombaan): View
    {
        $kriterias = $perlombaan->kriterias()->get();

        return view('admin.kriteria.index', [
            'perlombaan' => $perlombaan,
            'kriterias' => $kriterias,
            'totalBobot' => $kriterias->sum('bobot'),
        ]);
    }

    public function create(Perlombaan $perlombaan): View
    {
        return view('admin.kriteria.create', [
            'perlombaan' => $perlombaan,
            'kriteria' => new Kriteria([
                'urutan' => ($perlombaan->kriterias()->max('urutan') ?? 0) + 1,
            ]),
        ]);
    }

    public function store(StoreKriteriaRequest $request, Perlombaan $perlombaan): RedirectResponse
    {
        $perlombaan->kriterias()->create($request->validated());

        return redirect()
            ->route('admin.perlombaan.kriteria.index', $perlombaan)
            ->with('status', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Perlombaan $perlombaan, Kriteria $kriteria): View
    {
        $this->ensureBelongsToCompetition($perlombaan, $kriteria);

        return view('admin.kriteria.edit', [
            'perlombaan' => $perlombaan,
            'kriteria' => $kriteria,
        ]);
    }

    public function update(UpdateKriteriaRequest $request, Perlombaan $perlombaan, Kriteria $kriteria): RedirectResponse
    {
        $this->ensureBelongsToCompetition($perlombaan, $kriteria);

        $kriteria->update($request->validated());

        return redirect()
            ->route('admin.perlombaan.kriteria.index', $perlombaan)
            ->with('status', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Perlombaan $perlombaan, Kriteria $kriteria): RedirectResponse
    {
        $this->ensureBelongsToCompetition($perlombaan, $kriteria);

        $kriteria->deleteAndRefreshScores();

        return redirect()
            ->route('admin.perlombaan.kriteria.index', $perlombaan)
            ->with('status', 'Kriteria berhasil dihapus.');
    }

    protected function ensureBelongsToCompetition(Perlombaan $perlombaan, Kriteria $kriteria): void
    {
        abort_unless($kriteria->perlombaan_id === $perlombaan->id, 404);
    }
}
