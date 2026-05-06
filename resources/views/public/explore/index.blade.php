@extends('layouts.landing')

@section('title', 'Katalog Lomba')

@php
    $exploreSections = [
        [
            'id' => 'available',
            'eyebrow' => 'Pendaftaran Terbuka',
            'title' => 'Ambil Peluangmu Sekarang.',
            'description' => 'Jangan lewatkan kesempatan. Pilih kompetisi yang sesuai dengan bakatmu dan segera daftarkan dirimu sebelum kuota atau batas waktu berakhir.',
            'tone' => 'sky',
            'competitions' => $availableCompetitions,
            'empty' => 'Belum ada perlombaan baru yang dibuka saat ini. Pantau terus halaman ini!',
        ],
        [
            'id' => 'ongoing',
            'eyebrow' => 'Sedang Berlangsung',
            'title' => 'Tahap Penilaian Berjalan.',
            'description' => 'Pantau perlombaan yang sedang bergulir. Karya-karya terbaik dari para peserta saat ini sedang dalam proses evaluasi oleh dewan juri.',
            'tone' => 'orange',
            'competitions' => $ongoingCompetitions,
            'empty' => 'Tidak ada perlombaan yang sedang dalam masa pelaksanaan.',
        ],
        [
            'id' => 'past',
            'eyebrow' => 'Telah Selesai',
            'title' => 'Jejak Para Juara.',
            'description' => 'Lihat kembali arsip perlombaan yang telah usai. Jadikan karya para pemenang sebelumnya sebagai referensi dan inspirasi untuk kompetisi berikutnya.',
            'tone' => 'emerald',
            'competitions' => $pastCompetitions,
            'empty' => 'Belum terdapat rekam jejak perlombaan yang telah selesai.',
        ],
    ];

    // Penyesuaian warna Badge ala Esports (Garis Tepi Tegas)
    $toneClasses = [
        'sky' => [ // Lomba Tersedia (Merah - Emas)
            'badge' => 'bg-gradient-to-r from-red-900/60 to-black text-amber-400 border-l-2 border-amber-400',
        ],
        'orange' => [ // Sedang Berlangsung (Orange gelap)
            'badge' => 'bg-gradient-to-r from-orange-900/60 to-black text-orange-400 border-l-2 border-orange-500',
        ],
        'emerald' => [ // Telah Selesai (Abu-abu/Neutral)
            'badge' => 'bg-gradient-to-r from-neutral-800 to-black text-slate-400 border-l-2 border-slate-500',
        ],
    ];
@endphp

@section('content')
<section class="relative bg-black pt-32 pb-20 border-b border-red-900/30 overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-amber-500/10 rounded-full blur-[120px] pointer-events-none -z-0"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:items-end lg:gap-16">
            
            <div>
                <div class="inline-flex items-center gap-2 rounded-none border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-black px-4 py-2 text-[12px] font-black uppercase tracking-widest text-amber-400 backdrop-blur-sm">
                    <span class="material-symbols-outlined text-[16px] text-amber-400">workspace_premium</span>
                    Katalog Lomba
                </div>
                
                <h1 class="mt-6 max-w-4xl text-4xl font-black leading-tight tracking-tight text-white sm:text-5xl lg:text-[54px] uppercase">
                    Temukan Panggung Kompetisimu, 
                    <span class="block bg-gradient-to-r from-red-500 via-red-600 to-amber-400 bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(251,191,36,0.3)] mt-2">
                        Dan Ukir Prestasi Gemilang.
                    </span>
                </h1>
                <p class="mt-6 max-w-2xl text-base font-medium leading-relaxed text-slate-400 sm:text-lg">
                    Ratusan peserta telah bergabung. Jelajahi berbagai perlombaan bergengsi, pantau proses penjurian, dan temukan namamu di podium juara.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:pb-2">
                <div class="rounded-tl-2xl rounded-br-2xl border border-neutral-800 bg-[#0a0a0c] p-6 shadow-lg backdrop-blur-sm relative overflow-hidden group hover:border-amber-500/50 transition-colors">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-600 group-hover:bg-amber-400 transition-colors"></div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-slate-500">Lomba Aktif</p>
                    <p class="mt-2 text-4xl font-black tracking-tight text-amber-400 drop-shadow-[0_0_10px_rgba(251,191,36,0.3)]">{{ $availableCompetitions->count() + $ongoingCompetitions->count() }}</p>
                    <p class="mt-2 text-sm font-medium leading-relaxed text-slate-400">Kompetisi menanti karyamu.</p>
                </div>
                
                <div class="rounded-tl-2xl rounded-br-2xl bg-gradient-to-br from-red-600 to-red-900 p-6 text-white shadow-[0_0_25px_rgba(220,38,38,0.3)] border border-red-500/50">
                    <p class="text-[11px] font-black uppercase tracking-widest text-red-200">Pengumuman</p>
                    <p class="mt-2 text-4xl font-black tracking-tight text-white drop-shadow-md">{{ $publishedAnnouncementsCount }}</p>
                    <p class="mt-2 text-sm font-medium leading-relaxed text-red-100">Hasil akhir yang dirilis.</p>
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-wrap gap-4 border-t border-red-900/30 pt-8">
            <a href="#available" class="inline-flex h-11 items-center justify-center rounded-sm border border-neutral-700 bg-[#0a0a0c] px-6 text-[13px] font-black uppercase tracking-widest text-slate-400 transition hover:border-amber-400 hover:text-amber-400 skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Pendaftaran Buka</span>
            </a>
            <a href="#ongoing" class="inline-flex h-11 items-center justify-center rounded-sm border border-neutral-700 bg-[#0a0a0c] px-6 text-[13px] font-black uppercase tracking-widest text-slate-400 transition hover:border-amber-400 hover:text-amber-400 skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Sedang Berjalan</span>
            </a>
            <a href="#past" class="inline-flex h-11 items-center justify-center rounded-sm border border-neutral-700 bg-[#0a0a0c] px-6 text-[13px] font-black uppercase tracking-widest text-slate-400 transition hover:border-amber-400 hover:text-amber-400 skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Telah Selesai</span>
            </a>
        </div>
    </div>
</section>

@foreach ($exploreSections as $section)
    <section id="{{ $section['id'] }}" class="scroll-mt-24 py-20 sm:py-24 {{ $loop->odd ? 'bg-[#050505]' : 'bg-black' }}">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col gap-3 sm:max-w-3xl">
                <p class="text-[13px] font-black uppercase tracking-widest text-amber-500">
                    {{ $section['eyebrow'] }}
                </p>
                <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl">
                    {{ $section['title'] }}
                </h2>
                <p class="mt-2 text-base font-medium leading-relaxed text-slate-400">
                    {{ $section['description'] }}
                </p>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @forelse ($section['competitions'] as $competition)
                    
                    <article class="tilt-card flex flex-col rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl transition-colors hover:border-amber-500/70 hover:shadow-[0_0_30px_rgba(251,191,36,0.15)] group relative" 
                             style="transform-style: preserve-3d; will-change: transform;">
                        
                        <div class="flex flex-col h-full pointer-events-none" style="transform: translateZ(40px); transform-style: preserve-3d;">
                            
                            <div class="flex items-start justify-between gap-4">
                                <span class="inline-flex items-center px-3 py-1.5 text-[10px] font-black uppercase tracking-widest shadow-md {{ $toneClasses[$section['tone']]['badge'] }}">
                                    {{ str($competition->status)->replace('_', ' ')->title() }}
                                </span>
                                <span class="text-[11px] font-bold tracking-widest text-slate-500 pt-1">
                                    {{ optional($competition->announcement_at)->translatedFormat('d M Y') ?? optional($competition->submission_deadline_at)->translatedFormat('d M Y') ?? '-' }}
                                </span>
                            </div>

                            <h3 class="mt-6 text-xl font-black uppercase tracking-wide leading-snug text-white group-hover:text-amber-400 transition-colors">{{ $competition->nama_lomba }}</h3>
                            <p class="mt-3 text-sm font-medium leading-relaxed text-slate-400 line-clamp-3">{{ \Illuminate\Support\Str::limit($competition->deskripsi, 120) }}</p>

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

                        @if ($competition->resultsArePubliclyVisible())
                            <div class="mt-6 flex justify-end border-t border-neutral-800 pt-5 relative z-10 pointer-events-auto" style="transform: translateZ(60px); transform-style: preserve-3d;">
                                <a href="{{ route('pengumuman.show', $competition) }}" class="inline-flex items-center justify-center rounded-sm bg-red-600 px-6 py-2.5 text-[11px] font-black uppercase tracking-widest text-white transition hover:bg-red-700 shadow-[0_0_15px_rgba(220,38,38,0.2)] hover:shadow-[0_0_20px_rgba(251,191,36,0.4)] border border-transparent hover:border-amber-400 skew-x-[-10deg]">
                                    <span class="skew-x-[10deg] flex items-center">
                                        Lihat Pemenang <span class="material-symbols-outlined ml-2 text-[14px]">emoji_events</span>
                                    </span>
                                </a>
                            </div>
                        @else
                            <div class="pb-2"></div>
                        @endif

                    </article>
                @empty
                    <div class="flex flex-col items-center justify-center rounded-tl-[2rem] rounded-br-[2rem] border border-dashed border-neutral-700 bg-[#0a0a0c]/50 p-12 text-center lg:col-span-3">
                        <span class="material-symbols-outlined mb-3 text-4xl text-slate-600">inbox</span>
                        <p class="text-sm font-black uppercase tracking-widest text-slate-500">{{ $section['empty'] }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tiltCards = document.querySelectorAll('.tilt-card');

        tiltCards.forEach(card => {
            // Hilangkan transisi agar responsif mengikuti pergerakan mouse
            card.addEventListener('mouseenter', () => {
                card.style.transition = 'none';
            });

            // Kalkulasi rotasi X dan Y
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                // Set maksimal rotasi ke 12 derajat untuk efek dramatis
                const rotateX = ((y - centerY) / centerY) * -12; 
                const rotateY = ((x - centerX) / centerX) * 12;

                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });

            // Kembalikan posisi awal secara mulus saat kursor pergi
            card.addEventListener('mouseleave', () => {
                card.style.transition = 'transform 0.5s ease-out';
                card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg)`;
            });
        });
    });
</script>
@endsection