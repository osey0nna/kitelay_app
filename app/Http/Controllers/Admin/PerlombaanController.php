<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePerlombaanRequest;
use App\Http\Requests\Admin\UpdatePerlombaanRequest;
use App\Models\Perlombaan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PerlombaanController extends Controller
{
    public function index(): View
    {
        $perlombaans = Perlombaan::query()
            ->withCount(['kriterias', 'pendaftarans', 'juris'])
            ->latest()
            ->paginate(10);

        return view('admin.perlombaan.index', [
            'perlombaans' => $perlombaans,
            'statuses' => Perlombaan::statuses(),
        ]);
    }

    public function create(): View
    {
        return view('admin.perlombaan.create', [
            'perlombaan' => new Perlombaan(),
            'statuses' => Perlombaan::statuses(),
        ]);
    }

    public function store(StorePerlombaanRequest $request): RedirectResponse
    {
        $perlombaan = Perlombaan::create($this->validatedPayload($request->validated(), $request->user()->id));

        return redirect()
            ->route('admin.perlombaan.index')
            ->with('status', "Perlombaan {$perlombaan->nama_lomba} berhasil dibuat.");
    }

    public function edit(Perlombaan $perlombaan): View
    {
        return view('admin.perlombaan.edit', [
            'perlombaan' => $perlombaan,
            'statuses' => Perlombaan::statuses(),
        ]);
    }

    public function update(UpdatePerlombaanRequest $request, Perlombaan $perlombaan): RedirectResponse
    {
        $perlombaan->update($this->validatedPayload($request->validated(), $perlombaan->created_by));

        return redirect()
            ->route('admin.perlombaan.index')
            ->with('status', "Perlombaan {$perlombaan->nama_lomba} berhasil diperbarui.");
    }

    public function destroy(Perlombaan $perlombaan): RedirectResponse
    {
        $namaLomba = $perlombaan->nama_lomba;
        $perlombaan->deleteWithRelations();

        return redirect()
            ->route('admin.perlombaan.index')
            ->with('status', "Perlombaan {$namaLomba} berhasil dihapus.");
    }

    protected function validatedPayload(array $data, ?int $createdBy): array
    {
        $slug = filled($data['slug'] ?? null)
            ? Str::slug($data['slug'])
            : Str::slug($data['nama_lomba']);

        return [
            'created_by' => $createdBy,
            'nama_lomba' => $data['nama_lomba'],
            'slug' => $slug,
            'deskripsi' => $data['deskripsi'],
            'status' => $data['status'],
            'registration_start_at' => $data['registration_start_at'] ?? null,
            'registration_end_at' => $data['registration_end_at'] ?? null,
            'deadline_pendaftaran' => $data['deadline_pendaftaran'] ?? ($data['registration_end_at'] ?? null),
            'submission_deadline_at' => $data['submission_deadline_at'] ?? null,
            'announcement_at' => $data['announcement_at'] ?? null,
            'max_participants' => $data['max_participants'] ?? null,
        ];
    }
}
