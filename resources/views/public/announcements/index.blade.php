@extends('layouts.landing')

@section('title', 'Pengumuman Pemenang')

@section('content')
<section id="pengumuman-section" class="relative overflow-hidden bg-black pt-32 pb-20 min-h-screen border-b border-red-900/30">
    
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-amber-500/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <div id="cursor-glow" class="absolute w-[600px] h-[600px] bg-amber-500/15 rounded-full blur-[120px] pointer-events-none -translate-x-1/2 -translate-y-1/2 transition-opacity duration-500 opacity-0 z-0"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 rounded-none border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-black px-4 py-2 text-[12px] font-black uppercase tracking-widest text-amber-400 backdrop-blur-sm shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">campaign</span>
                Pengumuman Publik
            </div>
            
            <h1 class="mt-6 text-4xl font-black leading-tight tracking-tight text-white sm:text-5xl lg:text-[54px] uppercase">
                Rayakan Para Juara, 
                <span class="block bg-gradient-to-r from-red-500 via-red-600 to-amber-400 bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(251,191,36,0.3)] mt-2">
                    Temukan Inspirasi Karya.
                </span>
            </h1>
            
            <p class="mt-6 text-base font-medium leading-relaxed text-slate-400 sm:text-lg">
                Daftar resmi hasil perlombaan yang telah selesai. Jelajahi karya-karya terbaik, lihat perolehan nilai akhir, dan apresiasi para pemenang yang berhasil meraih podium.
            </p>
        </div>

        <div class="mt-16 grid gap-6 lg:grid-cols-3">
            @forelse ($competitions as $competition)
                
                <article class="tilt-card flex flex-col rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl transition-colors hover:border-amber-500/70 hover:shadow-[0_0_30px_rgba(251,191,36,0.15)] group relative" 
                         style="transform-style: preserve-3d; will-change: transform;">
                    
                    <div class="flex flex-col h-full pointer-events-none" style="transform: translateZ(40px); transform-style: preserve-3d;">
                        
                        <div>
                            <span class="inline-flex items-center px-3 py-1.5 text-[10px] font-black uppercase tracking-widest shadow-md bg-gradient-to-r from-red-900/60 to-black text-amber-400 border-l-2 border-amber-400">
                                {{ str($competition->status)->replace('_', ' ')->title() }}
                            </span>
                        </div>

                        <h2 class="mt-6 text-xl font-black uppercase tracking-wide leading-snug text-white group-hover:text-amber-400 transition-colors">{{ $competition->nama_lomba }}</h2>
                        <p class="mt-3 text-sm font-medium leading-relaxed text-slate-400 line-clamp-3">{{ \Illuminate\Support\Str::limit($competition->deskripsi, 130) }}</p>

                        <div class="mt-auto pt-8">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-xl bg-black py-3 text-center border border-slate-800/50 transition-colors group-hover:border-amber-900/50">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Peserta</p>
                                    <p class="mt-1 text-lg font-black text-white group-hover:text-amber-400">{{ $competition->pendaftarans_count }}</p>
                                </div>
                                <div class="rounded-xl bg-black py-3 text-center border border-slate-800/50 transition-colors group-hover:border-amber-900/50">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Kriteria</p>
                                    <p class="mt-1 text-lg font-black text-white group-hover:text-amber-400">{{ $competition->kriterias_count }}</p>
                                </div>
                                <div class="rounded-xl bg-black py-3 text-center border border-slate-800/50 transition-colors group-hover:border-amber-900/50">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Juri</p>
                                    <p class="mt-1 text-lg font-black text-white group-hover:text-amber-400">{{ $competition->juris_count }}</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end border-t border-neutral-800 pt-5 relative z-10 pointer-events-auto" style="transform: translateZ(60px); transform-style: preserve-3d;">
                        <a href="{{ route('pengumuman.show', $competition) }}" class="inline-flex items-center justify-center rounded-sm bg-red-600 px-6 py-2.5 text-[11px] font-black uppercase tracking-widest text-white transition hover:bg-red-700 shadow-[0_0_15px_rgba(220,38,38,0.2)] hover:shadow-[0_0_20px_rgba(251,191,36,0.4)] border border-transparent hover:border-amber-400 skew-x-[-10deg]">
                            <span class="skew-x-[10deg] flex items-center">
                                Lihat Pemenang <span class="material-symbols-outlined ml-2 text-[14px]">emoji_events</span>
                            </span>
                        </a>
                    </div>
                </article>

            @empty
                <div class="flex flex-col items-center justify-center rounded-tl-[2rem] rounded-br-[2rem] border border-dashed border-neutral-700 bg-[#0a0a0c]/50 p-12 text-center lg:col-span-3 relative z-10">
                    <span class="material-symbols-outlined mb-3 text-4xl text-slate-600 drop-shadow-md">workspace_premium</span>
                    <p class="text-sm font-black uppercase tracking-widest text-slate-500">Belum ada hasil perlombaan yang dirilis secara publik saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // ----------------------------------------------------
        // 1. EFEK GLOW INTERAKTIF (Latar Belakang Mengikuti Mouse)
        // ----------------------------------------------------
        const areaPengumuman = document.getElementById('pengumuman-section');
        const glowKursor = document.getElementById('cursor-glow');

        if (areaPengumuman && glowKursor) {
            areaPengumuman.addEventListener('mouseenter', () => {
                glowKursor.classList.remove('opacity-0');
                glowKursor.classList.add('opacity-100');
            });

            areaPengumuman.addEventListener('mouseleave', () => {
                glowKursor.classList.remove('opacity-100');
                glowKursor.classList.add('opacity-0');
            });

            areaPengumuman.addEventListener('mousemove', (e) => {
                const rect = areaPengumuman.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                glowKursor.style.left = `${x}px`;
                glowKursor.style.top = `${y}px`;
            });
        }

        // ----------------------------------------------------
        // 2. EFEK KARTU 3D TILT POP-OUT
        // ----------------------------------------------------
        const tiltCards = document.querySelectorAll('.tilt-card');

        tiltCards.forEach(card => {
            // Hilangkan transisi saat mouse bergerak agar pergerakan responsif
            card.addEventListener('mouseenter', () => {
                card.style.transition = 'none';
            });

            // Kalkulasi kemiringan berdasarkan posisi kursor di atas kartu
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                // Rotasi maksimal diset 10 derajat
                const rotateX = ((y - centerY) / centerY) * -10; 
                const rotateY = ((x - centerX) / centerX) * 10;

                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });

            // Kembalikan kartu ke posisi datar saat mouse keluar
            card.addEventListener('mouseleave', () => {
                card.style.transition = 'transform 0.5s ease-out';
                card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg)`;
            });
        });

    });
</script>
@endsection