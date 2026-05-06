<div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
    <div class="space-y-5 rounded-[1.75rem] border border-neutral-800 bg-neutral-900 p-6 shadow-sm">
        <div>
            <x-input-label for="nama_kriteria" value="Nama Kriteria" class="text-white" />
            <x-text-input id="nama_kriteria" name="nama_kriteria" type="text" 
                class="mt-2 block w-full rounded-2xl border-sky-500 bg-black text-white focus:border-sky-400 focus:ring-sky-400" 
                :value="old('nama_kriteria', $kriteria->nama_kriteria ?? '')" required autofocus />
            <x-input-error :messages="$errors->get('nama_kriteria')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="deskripsi" value="Deskripsi" class="text-white" />
            <textarea id="deskripsi" name="deskripsi" rows="6" 
                class="mt-2 block w-full rounded-2xl border-sky-500 bg-black text-sm text-white shadow-sm focus:border-sky-400 focus:ring-sky-400">{{ old('deskripsi', $kriteria->deskripsi ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
        </div>
    </div>

    <div class="space-y-5 rounded-[1.75rem] border border-neutral-800 bg-neutral-900 p-6 shadow-sm">
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="bobot" value="Bobot" class="text-white" />
                <x-text-input id="bobot" name="bobot" type="number" min="1" max="100" 
                    class="mt-2 block w-full rounded-2xl border-sky-500 bg-black text-white focus:border-sky-400 focus:ring-sky-400" 
                    :value="old('bobot', $kriteria->bobot ?? '')" required />
                <x-input-error :messages="$errors->get('bobot')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="urutan" value="Urutan" class="text-white" />
                <x-text-input id="urutan" name="urutan" type="number" min="1" 
                    class="mt-2 block w-full rounded-2xl border-sky-500 bg-black text-white focus:border-sky-400 focus:ring-sky-400" 
                    :value="old('urutan', $kriteria->urutan ?? '')" required />
                <x-input-error :messages="$errors->get('urutan')" class="mt-2" />
            </div>
        </div>

        <div class="rounded-2xl bg-black border border-neutral-800 p-5 text-sm leading-7 text-slate-400">
            <p class="font-bold text-white">Tips Pengaturan Bobot</p>
            <p class="mt-2">Pastikan total bobot seluruh kriteria mendekati atau sama dengan 100 agar perhitungan nilai akhir lebih mudah dan konsisten.</p>
        </div>
    </div>
</div>

<div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <a href="{{ route('admin.perlombaan.kriteria.index', $perlombaan) }}" 
        class="inline-flex items-center justify-center rounded-2xl border border-neutral-700 bg-neutral-900 px-5 py-3 text-sm font-bold text-white transition hover:border-neutral-500">
        Kembali
    </a>

    <button type="submit" 
        class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-sky-500">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>