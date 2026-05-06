<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 relative z-10">
            <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">gavel</span>
                <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Juri Workspace</span>
            </div>
            <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl">Daftar Tugas Juri</h2>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out" 
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <section class="rounded-xl border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl">
                <p class="text-[11px] font-black uppercase tracking-widest text-amber-500">Ringkasan</p>
                <h3 class="mt-2 text-2xl font-black uppercase tracking-wide text-white">Daftar lomba yang bisa kamu nilai sebagai juri.</h3>
                <p class="mt-3 text-sm text-slate-400">Setiap juri hanya melihat perlombaan yang ditugaskan oleh admin, jadi area kerja tetap fokus dan rapi.</p>
            </section>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @if(isset($perlombaans) && $perlombaans->count() > 0)
                    @foreach ($perlombaans as $lomba)
                        <article class="tilt-card flex flex-col justify-between rounded-xl border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl transition-all hover:border-amber-500/50">
                            
                            <div>
                                <span class="inline-block px-3 py-1 mb-4 text-[9px] font-black uppercase tracking-widest bg-sky-900/30 text-sky-400 border border-sky-500/30 skew-x-[-10deg]">
                                    <span class="skew-x-[10deg]">{{ str($lomba->status)->replace('_', ' ')->title() }}</span>
                                </span>
                                
                                <h3 class="text-xl font-black uppercase tracking-wide text-white">{{ $lomba->nama_lomba }}</h3>
                                <p class="mt-2 text-xs leading-relaxed text-slate-500 line-clamp-2">{{ $lomba->deskripsi }}</p>

                                <div class="mt-6 grid grid-cols-2 gap-3">
                                    <div class="rounded-xl border border-neutral-800 bg-[#050505] p-4 text-center">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Peserta</p>
                                        <p class="mt-1 text-2xl font-black text-white">{{ $lomba->pendaftarans_count ?? 0 }}</p>
                                    </div>
                                    <div class="rounded-xl border border-neutral-800 bg-[#050505] p-4 text-center">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Kriteria</p>
                                        <p class="mt-1 text-2xl font-black text-white">{{ $lomba->kriterias_count ?? 0 }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col gap-3">
                                <a href="{{ route('juri.penilaian.submissions', $lomba) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-sm bg-gradient-to-r from-red-600 to-red-800 px-4 py-3 text-[11px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,38,38,0.2)] transition-all hover:scale-105 skew-x-[-10deg]">
                                    <span class="skew-x-[10deg]">Lihat Submission</span>
                                </a>
                                <a href="{{ route('juri.penilaian.results', $lomba) }}" class="inline-flex w-full items-center justify-center rounded-sm border border-amber-500/50 bg-amber-900/10 px-4 py-3 text-[11px] font-black uppercase tracking-widest text-amber-400 transition-all hover:bg-amber-900/30 skew-x-[-10deg]">
                                    <span class="skew-x-[10deg]">Lihat Hasil & Podium</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                @else
                    <div class="col-span-full rounded-xl border border-dashed border-neutral-800 bg-[#0a0a0c] p-12 text-center">
                        <p class="text-sm font-black uppercase tracking-widest text-slate-500">Belum ada lomba yang ditugaskan untukmu.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiltCards = document.querySelectorAll('.tilt-card');
            tiltCards.forEach(card => {
                card.style.transition = 'transform 0.1s ease-out';
                card.style.transformStyle = 'preserve-3d';
                
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    // Rotasi diatur halus agar tidak merusak tata letak
                    const rotateX = ((y - rect.height / 2) / (rect.height / 2)) * -2;
                    const rotateY = ((x - rect.width / 2) / (rect.width / 2)) * 2;
                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transition = 'transform 0.5s ease-out';
                    card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                });
            });
        });
    </script>
</x-app-layout>