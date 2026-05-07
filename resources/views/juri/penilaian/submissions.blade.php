<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between relative z-10">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                    <span class="material-symbols-outlined text-[16px] text-amber-400">gavel</span>
                    <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Juri Workspace</span>
                </div>
                
                <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl drop-shadow-md">
                    Daftar Submission <span class="text-amber-400">Peserta</span>
                </h2>
                <p class="max-w-2xl text-sm font-medium leading-7 text-slate-400">Lomba: <span class="text-white">{{ $perlombaan->nama_lomba }}</span></p>
            </div>

            <a href="{{ route('juri.penilaian.index') }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-transparent px-6 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-500 hover:text-white transition-all skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Kembali ke Daftar Lomba</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 md:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            @if ($perlombaan->resultsAreVisible())
                <div class="flex justify-end">
                    <a href="{{ route('juri.penilaian.results', $perlombaan) }}" class="tilt-card inline-flex items-center justify-center rounded-sm border border-amber-500/50 bg-amber-900/20 px-6 py-3 text-[11px] font-black uppercase tracking-widest text-amber-400 transition hover:bg-amber-900/40 shadow-[0_0_15px_rgba(251,191,36,0.15)] skew-x-[-10deg]">
                        <span class="skew-x-[10deg]">Lihat Hasil & Podium</span>
                    </a>
                </div>
            @endif

            <section class="overflow-hidden rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] shadow-2xl relative">
                
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-600 via-amber-500 to-red-900"></div>

                <div class="px-6 py-5 border-b border-neutral-800 bg-[#050505] flex items-center gap-3">
                    <span class="material-symbols-outlined text-amber-500">folder_open</span>
                    <h3 class="text-[12px] font-black uppercase tracking-widest text-white">Daftar Karya Peserta</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-800 text-sm">
                        <thead class="bg-[#0a0a0c] text-left text-[10px] font-black uppercase tracking-widest text-amber-500 border-b border-neutral-700 shadow-sm">
                            <tr>
                                <th class="px-4 md:px-6 py-3 md:py-5 w-[20%]">Peserta</th>
                                <th class="px-4 md:px-6 py-3 md:py-5 w-[35%]">Submission</th>
                                <th class="px-4 md:px-6 py-3 md:py-5">Status</th>
                                <th class="px-4 md:px-6 py-3 md:py-5 text-center">Dinilai</th>
                                <th class="px-4 md:px-6 py-3 md:py-5 text-right w-[15%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800 bg-[#0a0a0c]">
                            @forelse ($pendaftarans as $pendaftaran)
                                <tr class="tilt-row transition-colors hover:bg-[#050505]">
                                    <td class="px-4 md:px-6 py-4 md:py-6 align-top">
                                        <p class="text-[14px] font-black uppercase tracking-wide text-white">{{ $pendaftaran->user->name }}</p>
                                        <p class="mt-1 text-[11px] font-medium text-slate-500">{{ $pendaftaran->user->email }}</p>
                                    </td>
                                    
                                    <td class="px-4 md:px-6 py-4 md:py-6 align-top">
                                        <p class="text-[14px] font-bold text-slate-300">{{ $pendaftaran->submission_title ?: 'Belum ada judul submission' }}</p>
                                        <p class="mt-2 max-w-md text-[12px] leading-relaxed text-slate-500 line-clamp-2">{{ $pendaftaran->submission_notes ?: 'Belum ada catatan submission.' }}</p>
                                        
                                        @if ($pendaftaran->hasStoredSubmissionFile())
                                            <div class="mt-4 flex flex-wrap gap-2">
                                                @if ($pendaftaran->submission_file_is_previewable)
                                                    <a href="{{ route('juri.penilaian.file.show', [$perlombaan, $pendaftaran]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-sm bg-sky-900/30 border border-sky-500/50 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-sky-400 transition hover:bg-sky-600 hover:text-white skew-x-[-10deg]">
                                                        <span class="skew-x-[10deg]">Lihat File</span>
                                                    </a>
                                                @endif
                                                <a href="{{ route('juri.penilaian.file.download', [$perlombaan, $pendaftaran]) }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-black px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-300 transition hover:border-slate-500 hover:text-white skew-x-[-10deg]">
                                                    <span class="skew-x-[10deg]">Unduh File</span>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-4 md:px-6 py-4 md:py-6 align-top">
                                        <span class="inline-flex px-3 py-1.5 text-[9px] font-black uppercase tracking-widest bg-gradient-to-r from-sky-900/40 to-black text-sky-400 border-l-2 border-sky-400 skew-x-[-10deg]">
                                            <span class="skew-x-[10deg]">{{ str($pendaftaran->status)->replace('_', ' ')->title() }}</span>
                                        </span>
                                    </td>
                                    
                                    <td class="px-4 md:px-6 py-4 md:py-6 align-top text-center">
                                        <span class="text-xl font-black text-white">{{ $pendaftaran->scored_items_count }}</span>
                                    </td>
                                    
                                    <td class="px-4 md:px-6 py-4 md:py-6 align-top">
                                        <div class="flex justify-end">
                                            <a href="{{ route('juri.penilaian.edit', [$perlombaan, $pendaftaran]) }}" class="inline-flex items-center justify-center rounded-sm bg-gradient-to-r from-red-600 to-red-800 px-5 py-2.5 text-[11px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,38,38,0.3)] transition-all hover:scale-105 skew-x-[-10deg]">
                                                <span class="skew-x-[10deg]">Nilai Peserta</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <span class="material-symbols-outlined text-4xl text-slate-700 mb-3 block">inbox</span>
                                        <p class="text-[12px] font-black uppercase tracking-widest text-slate-500">Belum ada peserta atau submission untuk perlombaan ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiltElements = document.querySelectorAll('.tilt-card, .tilt-row');
            
            tiltElements.forEach(el => {
                el.style.transformStyle = 'preserve-3d';
                
                el.addEventListener('mouseenter', () => {
                    el.style.transition = 'transform 0.1s ease-out, box-shadow 0.1s ease-out';
                    el.style.zIndex = "50"; 
                });

                el.addEventListener('mousemove', (e) => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = ((y - centerY) / centerY) * -12; 
                    const rotateY = ((x - centerX) / centerX) * 12;
                    const scale = el.classList.contains('tilt-row') ? 1.02 : 1.05;
                    
                    el.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(${scale})`;

                    const shadowX = ((x - centerX) / centerX) * -20;
                    const shadowY = ((y - centerY) / centerY) * -20;
                    
                    // Glow warna Amber/Keemasan khas Juri
                    el.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(251, 191, 36, 0.15), 0 0 15px rgba(220, 38, 38, 0.2)`;
                });

                el.addEventListener('mouseleave', () => {
                    el.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.6s ease-out';
                    el.style.transform = `perspective(800px) rotateX(0deg) rotateY(0deg) scale(1)`;
                    el.style.boxShadow = '';
                    el.style.zIndex = "1";
                });
            });
        });
    </script>
</x-app-layout>