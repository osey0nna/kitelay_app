@extends('layouts.landing')

@section('title', $perlombaan->nama_lomba.' | Podium Resmi')

@section('content')
<section class="relative bg-white pb-16 pt-32">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-semibold text-emerald-700">
                    <span class="material-symbols-outlined text-base">emoji_events</span>
                    Pengumuman Podium Resmi
                </div>
                <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                    {{ $perlombaan->nama_lomba }}
                </h1>
                <p class="mt-6 text-base leading-relaxed text-slate-600 sm:text-lg">
                    Berikut adalah podium resmi tiga besar yang diumumkan untuk lomba ini. Halaman publik hanya menampilkan nama peserta, nama lomba, dan urutan podium.
                </p>
            </div>

            <div class="pb-2">
                <a href="{{ route('pengumuman.index') }}" class="inline-flex h-11 items-center justify-center rounded-full border border-slate-200 bg-white px-6 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    <span class="material-symbols-outlined mr-2 text-base text-slate-400">arrow_back</span>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        @if ($podium->isNotEmpty())
            <div class="mt-16 grid gap-6 lg:grid-cols-3">
                @foreach ($podium as $participant)
                    @php
                        $cardClass = match ($participant->ranking_position) {
                            1 => 'border-amber-200 bg-gradient-to-br from-amber-50 to-white shadow-xl shadow-amber-900/5',
                            2 => 'border-slate-200 bg-white shadow-sm',
                            3 => 'border-orange-200 bg-gradient-to-br from-orange-50 to-white shadow-sm',
                            default => 'border-slate-200 bg-white shadow-sm',
                        };
                        $badgeClass = match ($participant->ranking_position) {
                            1 => 'bg-amber-100 text-amber-700',
                            2 => 'bg-slate-100 text-slate-600',
                            3 => 'bg-orange-100 text-orange-700',
                            default => 'bg-slate-100 text-slate-600',
                        };
                        $rankLabel = match ($participant->ranking_position) {
                            1 => 'Juara 1',
                            2 => 'Juara 2',
                            3 => 'Juara 3',
                            default => 'Podium',
                        };
                    @endphp

                    <article class="rounded-[2.5rem] border p-8 transition-transform hover:-translate-y-1 {{ $cardClass }}">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex rounded-full px-4 py-2 text-[11px] font-black uppercase tracking-[0.18em] {{ $badgeClass }}">
                                {{ $rankLabel }}
                            </span>
                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                Urutan {{ $participant->ranking_position }}
                            </span>
                        </div>

                        <h2 class="mt-10 text-3xl font-black tracking-[-0.04em] text-slate-950">{{ $participant->user->name }}</h2>
                        <p class="mt-4 text-sm font-semibold uppercase tracking-[0.16em] text-slate-400">Nama Lomba</p>
                        <p class="mt-2 text-lg font-bold text-slate-700">{{ $perlombaan->nama_lomba }}</p>
                    </article>
                @endforeach
            </div>
        @else
            <div class="mt-12 flex flex-col items-center justify-center rounded-[2.5rem] border-2 border-dashed border-slate-200 bg-slate-50 p-16 text-center">
                <span class="material-symbols-outlined mb-4 text-5xl text-slate-300">emoji_events</span>
                <p class="text-lg font-medium text-slate-500">Belum ada podium yang bisa dipublikasikan untuk lomba ini.</p>
            </div>
        @endif
    </div>
</section>
@endsection
