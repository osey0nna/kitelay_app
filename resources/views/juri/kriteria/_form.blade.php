<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <div class="space-y-5 rounded-[1.75rem] border border-neutral-800 bg-black p-6 shadow-xl">
        <div>
            <x-input-label for="nama_kriteria" value="Nama Kriteria" class="text-white" />
            <x-text-input id="nama_kriteria" name="nama_kriteria" type="text" class="mt-2 block w-full rounded-2xl border-neutral-700 bg-[#111111] text-white placeholder:text-slate-500 focus:border-amber-400 focus:ring-amber-400" :value="old('nama_kriteria', $kriteria->nama_kriteria)" required autofocus />
            <x-input-error :messages="$errors->get('nama_kriteria')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="deskripsi" value="Deskripsi" class="text-white" />
            <textarea id="deskripsi" name="deskripsi" rows="6" class="mt-2 block w-full rounded-2xl border-neutral-700 bg-[#111111] text-sm text-white shadow-sm focus:border-amber-400 focus:ring-amber-400">{{ old('deskripsi', $kriteria->deskripsi) }}</textarea>
            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
        </div>
    </div>

    <div class="space-y-5 rounded-[1.75rem] border border-neutral-800 bg-black p-6 shadow-xl">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="bobot" value="Bobot" class="text-white" />
                <x-text-input id="bobot" name="bobot" type="number" min="1" max="100" class="mt-2 block w-full rounded-2xl border-neutral-700 bg-[#111111] text-white focus:border-amber-400 focus:ring-amber-400" :value="old('bobot', $kriteria->bobot)" required />
                <x-input-error :messages="$errors->get('bobot')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="urutan" value="Urutan" class="text-white" />
                <x-text-input id="urutan" name="urutan" type="number" min="1" class="mt-2 block w-full rounded-2xl border-neutral-700 bg-[#111111] text-white focus:border-amber-400 focus:ring-amber-400" :value="old('urutan', $kriteria->urutan)" required />
                <x-input-error :messages="$errors->get('urutan')" class="mt-2" />
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-800 bg-[#111111] p-5 text-sm leading-7 text-slate-300">
            <p class="font-bold text-white">Catatan Workspace Juri</p>
            <p class="mt-2">Perubahan kriteria akan langsung memengaruhi struktur penilaian lomba ini. Kalau kriteria dihapus, nilai yang terkait akan ikut dibersihkan dan skor akhir peserta dihitung ulang.</p>
        </div>
    </div>
</div>

<div class="mt-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <a href="{{ route('juri.kriteria.index', $perlombaan) }}" class="inline-flex items-center justify-center rounded-2xl border border-neutral-700 bg-black px-5 py-3 text-sm font-bold text-white transition hover:border-amber-400 hover:text-white">
        Kembali
    </a>

    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-red-700 px-6 py-3 text-sm font-bold text-white transition hover:bg-red-600">
        {{ $submitLabel }}
    </button>
</div>
