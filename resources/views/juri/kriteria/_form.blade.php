<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <div class="space-y-5 rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div>
            <x-input-label for="nama_kriteria" value="Nama Kriteria" />
            <x-text-input id="nama_kriteria" name="nama_kriteria" type="text" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('nama_kriteria', $kriteria->nama_kriteria)" required autofocus />
            <x-input-error :messages="$errors->get('nama_kriteria')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="deskripsi" value="Deskripsi" />
            <textarea id="deskripsi" name="deskripsi" rows="6" class="mt-2 block w-full rounded-2xl border-slate-200 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $kriteria->deskripsi) }}</textarea>
            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
        </div>
    </div>

    <div class="space-y-5 rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="bobot" value="Bobot" />
                <x-text-input id="bobot" name="bobot" type="number" min="1" max="100" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('bobot', $kriteria->bobot)" required />
                <x-input-error :messages="$errors->get('bobot')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="urutan" value="Urutan" />
                <x-text-input id="urutan" name="urutan" type="number" min="1" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('urutan', $kriteria->urutan)" required />
                <x-input-error :messages="$errors->get('urutan')" class="mt-2" />
            </div>
        </div>

        <div class="rounded-2xl bg-slate-50 p-5 text-sm leading-7 text-slate-600">
            <p class="font-bold text-slate-900">Catatan Workspace Juri</p>
            <p class="mt-2">Perubahan kriteria akan langsung memengaruhi struktur penilaian lomba ini. Kalau kriteria dihapus, nilai yang terkait akan ikut dibersihkan dan skor akhir peserta dihitung ulang.</p>
        </div>
    </div>
</div>

<div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <a href="{{ route('juri.kriteria.index', $perlombaan) }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
        Kembali
    </a>

    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
        {{ $submitLabel }}
    </button>
</div>
