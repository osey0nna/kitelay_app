@extends('layouts.landing')

@section('title', $perlombaan->nama_lomba.' | Podium Resmi')

@section('content')
<section id="podium-section" class="relative bg-black pb-24 pt-32 min-h-screen overflow-hidden border-b border-red-900/30">
    
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-amber-500/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
    
    <div id="cursor-glow" class="absolute w-[600px] h-[600px] bg-amber-500/10 rounded-full blur-[120px] pointer-events-none -translate-x-1/2 -translate-y-1/2 transition-opacity duration-500 opacity-0 z-0"></div>

    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-none border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-black px-4 py-2 text-[12px] font-black uppercase tracking-widest text-amber-400 backdrop-blur-sm shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                    <span class="material-symbols-outlined text-[16px]">emoji_events</span>
                    Pengumuman Podium Resmi
                </div>
                
                <h1 class="mt-6 text-4xl font-black leading-tight tracking-tight text-white uppercase sm:text-5xl drop-shadow-md">
                    {{ $perlombaan->nama_lomba }}
                </h1>
                
                <p class="mt-4 text-base font-medium leading-relaxed text-slate-400 sm:text-lg">
                    Berikut adalah podium resmi tiga besar yang diumumkan untuk lomba ini. Halaman publik hanya menampilkan nama peserta, nama lomba, dan urutan podium.
                </p>
            </div>

            <div class="pb-2">
                <a href="{{ route('pengumuman.index') }}" class="inline-flex h-11 items-center justify-center rounded-sm border border-neutral-800 bg-[#0a0a0c] px-6 text-[13px] font-black uppercase tracking-widest text-slate-400 transition hover:border-amber-400 hover:text-amber-400 skew-x-[-10deg] group shadow-lg">
                    <span class="skew-x-[10deg] flex items-center">
                        <span class="material-symbols-outlined mr-2 text-[18px] transition-transform group-hover:-translate-x-1">arrow_back</span>
                        Kembali
                    </span>
                </a>
            </div>
        </div>

        @if ($podium->isNotEmpty())
            <div class="mt-16 grid gap-6 lg:grid-cols-3">
                @foreach ($podium as $participant)
                    @php
                        // Logika Tema Warna Spesifik untuk Juara 1 (Emas), 2 (Perak), 3 (Perunggu)
                        $cardClass = match ($participant->ranking_position) {
                            1 => 'border-amber-400 bg-gradient-to-br from-amber-900/30 to-[#0a0a0c] shadow-[0_0_30px_rgba(251,191,36,0.2)] hover:shadow-[0_0_40px_rgba(251,191,36,0.4)]',
                            2 => 'border-slate-400 bg-gradient-to-br from-slate-700/30 to-[#0a0a0c] shadow-[0_0_20px_rgba(148,163,184,0.15)] hover:shadow-[0_0_30px_rgba(148,163,184,0.3)]',
                            3 => 'border-orange-600 bg-gradient-to-br from-orange-900/30 to-[#0a0a0c] shadow-[0_0_20px_rgba(234,88,12,0.15)] hover:shadow-[0_0_30px_rgba(234,88,12,0.3)]',
                            default => 'border-neutral-800 bg-[#0a0a0c] shadow-lg',
                        };
                        
                        $badgeClass = match ($participant->ranking_position) {
                            1 => 'bg-amber-400 text-black shadow-[0_0_10px_rgba(251,191,36,0.5)]',
                            2 => 'bg-slate-300 text-black shadow-[0_0_10px_rgba(148,163,184,0.5)]',
                            3 => 'bg-orange-500 text-black shadow-[0_0_10px_rgba(234,88,12,0.5)]',
                            default => 'bg-neutral-800 text-slate-400',
                        };
                        
                        $rankLabel = match ($participant->ranking_position) {
                            1 => 'Juara 1',
                            2 => 'Juara 2',
                            3 => 'Juara 3',
                            default => 'Podium',
                        };

                        $textHighlightClass = match ($participant->ranking_position) {
                            1 => 'text-amber-400',
                            2 => 'text-slate-300',
                            3 => 'text-orange-500',
                            default => 'text-red-500',
                        };
                    @endphp

                    <article class="tilt-card rounded-tl-[2.5rem] rounded-br-[2.5rem] rounded-tr-sm rounded-bl-sm border p-8 transition-colors relative {{ $cardClass }}" 
                             style="transform-style: preserve-3d; will-change: transform;">
                        
                        <div class="flex flex-col h-full pointer-events-none" style="transform: translateZ(50px); transform-style: preserve-3d;">
                            
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-4 py-1.5 text-[11px] font-black uppercase tracking-[0.18em] skew-x-[-10deg] {{ $badgeClass }}">
                                    <span class="skew-x-[10deg] flex items-center gap-1">
                                        @if($participant->ranking_position == 1) <span class="material-symbols-outlined text-[14px]">trophy</span> @endif
                                        {{ $rankLabel }}
                                    </span>
                                </span>
                                <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">
                                    Urutan {{ $participant->ranking_position }}
                                </span>
                            </div>

                            <h2 class="mt-12 text-3xl font-black uppercase tracking-widest text-white drop-shadow-lg">{{ $participant->user->name }}</h2>
                            
                            <div class="mt-6 border-t border-white/10 pt-4">
                                <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-500">Nama Lomba</p>
                                <p class="mt-1 text-lg font-black uppercase tracking-wide {{ $textHighlightClass }} drop-shadow-md">{{ $perlombaan->nama_lomba }}</p>
                            </div>

                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-12 flex flex-col items-center justify-center rounded-tl-[3rem] rounded-br-[3rem] rounded-tr-sm rounded-bl-sm border-2 border-dashed border-neutral-800 bg-[#0a0a0c]/50 p-16 text-center relative z-10 shadow-2xl">
                <span class="material-symbols-outlined mb-4 text-5xl text-slate-600 drop-shadow-md">emoji_events</span>
                <p class="text-[14px] font-black uppercase tracking-widest text-slate-500">Belum ada podium yang bisa dipublikasikan untuk lomba ini.</p>
            </div>
        @endif
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // 1. EFEK GLOW KURSOR
        const areaPodium = document.getElementById('podium-section');
        const glowKursor = document.getElementById('cursor-glow');

        if (areaPodium && glowKursor) {
            areaPodium.addEventListener('mouseenter', () => {
                glowKursor.classList.remove('opacity-0');
                glowKursor.classList.add('opacity-100');
            });

            areaPodium.addEventListener('mouseleave', () => {
                glowKursor.classList.remove('opacity-100');
                glowKursor.classList.add('opacity-0');
            });

            areaPodium.addEventListener('mousemove', (e) => {
                const rect = areaPodium.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                glowKursor.style.left = `${x}px`;
                glowKursor.style.top = `${y}px`;
            });
        }

        // 2. EFEK KARTU 3D TILT
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