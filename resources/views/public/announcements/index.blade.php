@extends('layouts.landing')

@section('title', 'Pengumuman Pemenang')

@section('content')
<section class="relative bg-white pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700">
                <span class="material-symbols-outlined text-base text-[#1e2460]">campaign</span>
                Pengumuman Publik
            </div>
            
            <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl lg:text-[54px]">
                Rayakan para juara, 
                <span class="block bg-gradient-to-r from-[#1e2460] to-indigo-600 bg-clip-text text-transparent">
                    temukan inspirasi karya.
                </span>
            </h1>
            
            <p class="mt-6 text-base leading-relaxed text-slate-600 sm:text-lg">
                Daftar resmi hasil perlombaan yang telah selesai. Jelajahi karya-karya terbaik, lihat perolehan nilai akhir, dan apresiasi para pemenang yang berhasil meraih podium.
            </p>
        </div>

        <div class="mt-16 grid gap-6 lg:grid-cols-3">
            @forelse ($competitions as $competition)
                <article class="flex flex-col rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                    
                    <div>
                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700">
                            {{ str($competition->status)->replace('_', ' ')->title() }}
                        </span>
                    </div>

                    <h2 class="mt-5 text-xl font-bold leading-snug text-slate-900">{{ $competition->nama_lomba }}</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600 line-clamp-3">{{ \Illuminate\Support\Str::limit($competition->deskripsi, 130) }}</p>

                    <div class="mt-auto pt-8">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-2xl border border-slate-100 bg-slate-50 py-3 text-center">
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Peserta</p>
                                <p class="mt-1 text-lg font-bold text-[#1e2460]">{{ $competition->pendaftarans_count }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-100 bg-slate-50 py-3 text-center">
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Kriteria</p>
                                <p class="mt-1 text-lg font-bold text-[#1e2460]">{{ $competition->kriterias_count }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-100 bg-slate-50 py-3 text-center">
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Juri</p>
                                <p class="mt-1 text-lg font-bold text-[#1e2460]">{{ $competition->juris_count }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end border-t border-slate-100 pt-5">
                        <a href="{{ route('pengumuman.show', $competition) }}" class="inline-flex items-center justify-center rounded-full bg-[#1e2460] px-6 py-2.5 text-xs font-semibold text-white transition hover:bg-[#141842]">
                            Lihat Pemenang <span class="material-symbols-outlined ml-1 text-[14px]">emoji_events</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="flex flex-col items-center justify-center rounded-[2rem] border border-dashed border-slate-300 bg-slate-50 p-12 text-center lg:col-span-3">
                    <span class="material-symbols-outlined mb-3 text-3xl text-slate-400">workspace_premium</span>
                    <p class="text-sm font-medium text-slate-600">Belum ada hasil perlombaan yang dirilis secara publik saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection