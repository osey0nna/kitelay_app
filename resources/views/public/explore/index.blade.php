@extends('layouts.landing')

@section('title', 'Katalog Lomba')

@php
    // Teks dirombak total menjadi bahasa promosi yang mengundang aksi (Call to Action)
    $exploreSections = [
        [
            'id' => 'available',
            'eyebrow' => 'Pendaftaran Terbuka',
            'title' => 'Ambil peluangmu sekarang.',
            'description' => 'Jangan lewatkan kesempatan. Pilih kompetisi yang sesuai dengan bakatmu dan segera daftarkan dirimu sebelum kuota atau batas waktu berakhir.',
            'tone' => 'sky',
            'competitions' => $availableCompetitions,
            'empty' => 'Belum ada perlombaan baru yang dibuka saat ini. Pantau terus halaman ini!',
        ],
        [
            'id' => 'ongoing',
            'eyebrow' => 'Sedang Berlangsung',
            'title' => 'Kompetisi dalam tahap penilaian.',
            'description' => 'Pantau perlombaan yang sedang bergulir. Karya-karya terbaik dari para peserta saat ini sedang dalam proses evaluasi oleh dewan juri.',
            'tone' => 'orange',
            'competitions' => $ongoingCompetitions,
            'empty' => 'Tidak ada perlombaan yang sedang dalam masa pelaksanaan.',
        ],
        [
            'id' => 'past',
            'eyebrow' => 'Telah Selesai',
            'title' => 'Jejak para juara.',
            'description' => 'Lihat kembali arsip perlombaan yang telah usai. Jadikan karya para pemenang sebelumnya sebagai referensi dan inspirasi untuk kompetisi berikutnya.',
            'tone' => 'emerald',
            'competitions' => $pastCompetitions,
            'empty' => 'Belum terdapat rekam jejak perlombaan yang telah selesai.',
        ],
    ];

    $toneClasses = [
        'sky' => [
            'badge' => 'bg-indigo-50 text-indigo-700',
            'card' => 'bg-indigo-50 text-indigo-700',
        ],
        'orange' => [
            'badge' => 'bg-amber-50 text-amber-700',
            'card' => 'bg-amber-50 text-amber-700',
        ],
        'emerald' => [
            'badge' => 'bg-emerald-50 text-emerald-700',
            'card' => 'bg-emerald-50 text-emerald-700',
        ],
    ];
@endphp

@section('content')
<section class="relative bg-white pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:items-end lg:gap-16">
            
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700">
                    <span class="material-symbols-outlined text-base text-[#1e2460]">workspace_premium</span>
                    Katalog Lomba
                </div>
                <h1 class="mt-6 max-w-4xl text-4xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl lg:text-[54px]">
                    Temukan panggung kompetisimu, 
                    <span class="block bg-gradient-to-r from-[#1e2460] to-indigo-600 bg-clip-text text-transparent">
                        dan ukir prestasi gemilang.
                    </span>
                </h1>
                <p class="mt-6 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg">
                    Ratusan peserta telah bergabung. Jelajahi berbagai perlombaan bergengsi, pantau proses penjurian, dan temukan namamu di podium juara.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:pb-2">
                <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Lomba Aktif</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-[#1e2460]">{{ $availableCompetitions->count() + $ongoingCompetitions->count() }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">Kompetisi yang siap menanti karyamu.</p>
                </div>
                <div class="rounded-3xl bg-[#1e2460] p-6 text-white shadow-lg shadow-indigo-900/15">
                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-200">Pengumuman Publik</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight">{{ $publishedAnnouncementsCount }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-indigo-100">Hasil akhir yang telah dirilis resmi.</p>
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-wrap gap-3 border-t border-slate-100 pt-8">
            <a href="#available" class="inline-flex h-11 items-center justify-center rounded-full bg-slate-100 px-6 text-sm font-medium text-slate-700 transition hover:-translate-y-0.5 hover:bg-slate-200">Pendaftaran Buka</a>
            <a href="#ongoing" class="inline-flex h-11 items-center justify-center rounded-full bg-slate-100 px-6 text-sm font-medium text-slate-700 transition hover:-translate-y-0.5 hover:bg-slate-200">Sedang Berjalan</a>
            <a href="#past" class="inline-flex h-11 items-center justify-center rounded-full bg-slate-100 px-6 text-sm font-medium text-slate-700 transition hover:-translate-y-0.5 hover:bg-slate-200">Telah Selesai</a>
        </div>
    </div>
</section>

@foreach ($exploreSections as $section)
    <section id="{{ $section['id'] }}" class="scroll-mt-24 py-20 sm:py-24 {{ $loop->odd ? 'bg-slate-50' : 'bg-white' }}">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3 sm:max-w-3xl">
                <p class="text-xs font-bold uppercase tracking-wider text-[#1e2460]">
                    {{ $section['eyebrow'] }}
                </p>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    {{ $section['title'] }}
                </h2>
                <p class="mt-2 text-base leading-relaxed text-slate-600">
                    {{ $section['description'] }}
                </p>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @forelse ($section['competitions'] as $competition)
                    <article class="flex flex-col rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                        
                        <div class="flex items-start justify-between gap-4">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wider {{ $toneClasses[$section['tone']]['badge'] }}">
                                {{ str($competition->status)->replace('_', ' ')->title() }}
                            </span>
                            <span class="text-xs font-medium text-slate-500 pt-1">
                                {{ optional($competition->announcement_at)->translatedFormat('d M Y') ?? optional($competition->submission_deadline_at)->translatedFormat('d M Y') ?? '-' }}
                            </span>
                        </div>

                        <h3 class="mt-5 text-xl font-bold leading-snug text-slate-900">{{ $competition->nama_lomba }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600 line-clamp-3">{{ \Illuminate\Support\Str::limit($competition->deskripsi, 150) }}</p>

                        <div class="mt-auto pt-8">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-2xl bg-slate-50 py-3 text-center border border-slate-100">
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Peserta</p>
                                    <p class="mt-1 text-lg font-bold text-[#1e2460]">{{ $competition->pendaftarans_count }}</p>
                                </div>
                                <div class="rounded-2xl bg-slate-50 py-3 text-center border border-slate-100">
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Kriteria</p>
                                    <p class="mt-1 text-lg font-bold text-[#1e2460]">{{ $competition->kriterias_count }}</p>
                                </div>
                                <div class="rounded-2xl bg-slate-50 py-3 text-center border border-slate-100">
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Juri</p>
                                    <p class="mt-1 text-lg font-bold text-[#1e2460]">{{ $competition->juris_count }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($competition->resultsArePubliclyVisible())
                            <div class="mt-6 flex justify-end border-t border-slate-100 pt-5">
                                <a href="{{ route('pengumuman.show', $competition) }}" class="inline-flex items-center justify-center rounded-full bg-[#1e2460] px-6 py-2.5 text-xs font-semibold text-white transition hover:bg-[#141842]">
                                    Lihat Pemenang <span class="material-symbols-outlined ml-1 text-[14px]">emoji_events</span>
                                </a>
                            </div>
                        @else
                            <div class="pb-2"></div>
                        @endif
                    </article>
                @empty
                    <div class="flex flex-col items-center justify-center rounded-[2rem] border border-dashed border-slate-300 bg-slate-50 p-12 text-center lg:col-span-3">
                        <span class="material-symbols-outlined mb-3 text-3xl text-slate-400">inbox</span>
                        <p class="text-sm font-medium text-slate-600">{{ $section['empty'] }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endforeach
@endsection