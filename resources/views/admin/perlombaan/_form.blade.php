<div class="space-y-6">
    <div>
        <label for="nama_lomba" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">
            Nama Perlombaan
        </label>
        <input type="text" id="nama_lomba" name="nama_lomba" 
               value="{{ old('nama_lomba', $perlombaan->nama_lomba ?? '') }}" 
               class="block w-full rounded-sm border border-neutral-800 bg-black px-4 py-3 text-sm text-white focus:border-amber-400 focus:ring-amber-400 transition-colors" 
               placeholder="Contoh: Lomba Desain Layang-layang Hias" required autofocus>
        @error('nama_lomba')
            <p class="mt-2 text-[11px] font-bold tracking-widest text-red-500 uppercase">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="deskripsi" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">
            Deskripsi Lengkap
        </label>
        <textarea id="deskripsi" name="deskripsi" rows="5" 
                  class="block w-full rounded-sm border border-neutral-800 bg-black px-4 py-3 text-sm text-white focus:border-amber-400 focus:ring-amber-400 transition-colors" 
                  placeholder="Jelaskan detail lomba, syarat, dan ketentuan di sini..." required>{{ old('deskripsi', $perlombaan->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="mt-2 text-[11px] font-bold tracking-widest text-red-500 uppercase">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="status" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">
                Status Pendaftaran
            </label>
            <div class="relative">
                <select id="status" name="status" 
                        class="block w-full appearance-none rounded-sm border border-neutral-800 bg-black px-4 py-3 text-sm text-white focus:border-amber-400 focus:ring-amber-400 transition-colors cursor-pointer">
                    <option value="draft" {{ old('status', $perlombaan->status ?? '') == 'draft' ? 'selected' : '' }}>Draft (Disembunyikan)</option>
                    <option value="pendaftaran_buka" {{ old('status', $perlombaan->status ?? '') == 'pendaftaran_buka' ? 'selected' : '' }}>Pendaftaran Buka</option>
                    <option value="pendaftaran_tutup" {{ old('status', $perlombaan->status ?? '') == 'pendaftaran_tutup' ? 'selected' : '' }}>Pendaftaran Tutup</option>
                    <option value="pengumuman" {{ old('status', $perlombaan->status ?? '') == 'pengumuman' ? 'selected' : '' }}>Pengumuman Hasil</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-amber-500">
                    <span class="material-symbols-outlined text-lg">expand_more</span>
                </div>
            </div>
            @error('status')
                <p class="mt-2 text-[11px] font-bold tracking-widest text-red-500 uppercase">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="deadline_pendaftaran" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2">
                Deadline Pendaftaran
            </label>
            <input type="date" id="deadline_pendaftaran" name="deadline_pendaftaran" 
                   value="{{ old('deadline_pendaftaran', isset($perlombaan->deadline_pendaftaran) ? \Carbon\Carbon::parse($perlombaan->deadline_pendaftaran)->format('Y-m-d') : '') }}" 
                   class="block w-full rounded-sm border border-neutral-800 bg-black px-4 py-3 text-sm text-white focus:border-amber-400 focus:ring-amber-400 transition-colors cursor-pointer [color-scheme:dark]" 
                   required>
            @error('deadline_pendaftaran')
                <p class="mt-2 text-[11px] font-bold tracking-widest text-red-500 uppercase">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="mt-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-neutral-800 pt-8">
    <p class="text-[11px] font-medium leading-relaxed text-slate-500 max-w-sm">
        Pastikan detail perlombaan sudah benar. Penugasan juri dan input kriteria nilai dapat dilakukan setelah lomba ini disimpan.
    </p>
    
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('admin.perlombaan.index') }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-transparent px-6 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-500 hover:text-white transition-all skew-x-[-10deg]">
            <span class="skew-x-[10deg]">Batal & Kembali</span>
        </a>
        
        <button type="submit" class="inline-flex items-center justify-center rounded-sm bg-gradient-to-r from-red-600 to-red-800 px-8 py-3 text-[11px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:shadow-[0_0_25px_rgba(251,191,36,0.3)] hover:border-amber-400 border border-transparent hover:-translate-y-0.5 transition-all skew-x-[-10deg]">
            <span class="skew-x-[10deg]">{{ $submitLabel ?? 'Simpan Lomba' }}</span>
        </button>
    </div>
</div>