@php
    $acceptedExtensions = \App\Http\Requests\Peserta\UpdateSubmissionRequest::acceptedExtensions();
    $acceptAttribute = collect($acceptedExtensions)->map(fn ($extension) => '.'.$extension)->implode(',');
    $maxUploadMb = (int) (\App\Http\Requests\Peserta\UpdateSubmissionRequest::maxUploadKilobytes() / 1024);
    $currentFileUrl = $pendaftaran->submission_file_url;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 relative z-10">
            <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">upload_file</span>
                <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Submission Arena</span>
            </div>
            <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl">Submission <span class="text-amber-400">Lomba</span></h2>
            <p class="text-sm font-medium text-slate-400">{{ $pendaftaran->perlombaan->nama_lomba }}</p>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <form method="POST" action="{{ route('peserta.lomba.update', $pendaftaran) }}" enctype="multipart/form-data" 
                  class="rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl transition-all hover:border-neutral-700">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    <div>
                        <x-input-label for="submission_title" value="Judul Submission" class="text-slate-400 font-black uppercase tracking-widest text-[11px]" />
                        <input id="submission_title" name="submission_title" type="text" class="mt-3 block w-full rounded-sm border-neutral-800 bg-black text-white px-4 py-3 text-sm focus:border-amber-400 focus:ring-amber-400 transition-all" :value="old('submission_title', $pendaftaran->submission_title)" required autofocus />
                        <x-input-error :messages="$errors->get('submission_title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="file_hasil" value="Upload File Hasil" class="text-slate-400 font-black uppercase tracking-widest text-[11px]" />
                        <p class="mt-2 text-[12px] leading-relaxed text-slate-500 font-medium">Maksimal {{ $maxUploadMb }} MB.</p>
                        
                        <input id="file_hasil" name="file_hasil" type="file" accept="{{ $acceptAttribute }}" 
                               class="mt-3 block w-full rounded-sm border border-neutral-800 bg-black px-4 py-3 text-sm text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-red-900/30 file:text-red-400 hover:file:bg-red-900/50 cursor-pointer">
                        <x-input-error :messages="$errors->get('file_hasil')" class="mt-2" />

                        <div class="mt-4 rounded-xl border border-neutral-800 bg-black p-5">
                            <p class="font-black text-[11px] uppercase tracking-widest text-white mb-4">Format file yang didukung</p>
                            <div class="grid gap-4 sm:grid-cols-2 text-[12px] text-slate-500 font-medium">
                                <div><p class="text-amber-500 font-black">Dokumen</p><p>PDF, DOCX, PPTX</p></div>
                                <div><p class="text-amber-500 font-black">Arsip</p><p>ZIP, RAR</p></div>
                                <div><p class="text-amber-500 font-black">Desain</p><p>JPG, PNG, SVG, PSD</p></div>
                                <div><p class="text-amber-500 font-black">Video</p><p>MP4, MOV</p></div>
                            </div>
                        </div>

                        @if ($pendaftaran->file_hasil)
                            <div class="mt-4 rounded-xl bg-neutral-900/50 p-4 border border-neutral-800">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">File saat ini</p>
                                <p class="mt-1 text-[13px] text-white break-all font-mono">{{ $pendaftaran->file_hasil }}</p>
                                <div class="mt-3 flex gap-4">
                                    @if ($pendaftaran->submission_file_is_previewable)
                                        <a href="{{ $currentFileUrl }}" target="_blank" class="text-[11px] font-black uppercase tracking-widest text-amber-500 hover:text-amber-300">Buka File</a>
                                    @endif
                                    <a href="{{ $currentFileUrl }}" download class="text-[11px] font-black uppercase tracking-widest text-red-500 hover:text-red-300">Unduh File</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <x-input-label for="submission_notes" value="Catatan Submission" class="text-slate-400 font-black uppercase tracking-widest text-[11px]" />
                        <textarea id="submission_notes" name="submission_notes" rows="6" class="mt-3 block w-full rounded-sm border-neutral-800 bg-black text-white text-sm focus:border-amber-400 focus:ring-amber-400 transition-all">{{ old('submission_notes', $pendaftaran->submission_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('submission_notes')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-neutral-800 pt-8">
                    <p class="text-[11px] font-medium leading-relaxed text-slate-500 max-w-sm">File submission akan disimpan ke media penyimpanan aktif. Ganti file kapan saja sebelum deadline.</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('peserta.lomba.index') }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-transparent px-6 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-500 transition-all skew-x-[-10deg]">
                            <span class="skew-x-[10deg]">Kembali</span>
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-sm bg-gradient-to-r from-red-600 to-red-800 px-8 py-3 text-[11px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:scale-105 transition-all skew-x-[-10deg]">
                            <span class="skew-x-[10deg]">Simpan Submission</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>