<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-600">Juri Workspace</p>
            <h2 class="text-2xl font-bold text-slate-900">Perlombaan yang Ditugaskan</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <x-page-hero
                eyebrow="Ringkasan"
                title="Daftar lomba yang bisa kamu nilai sebagai juri."
                description="Setiap juri hanya melihat perlombaan yang memang di-assign admin, jadi area kerja tetap fokus dan rapi."
                accent="orange"
            />

            <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
                @forelse ($perlombaans as $perlombaan)
                    <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-600">{{ str($perlombaan->status)->replace('_', ' ')->title() }}</p>
                        <h3 class="mt-3 text-2xl font-black tracking-[-0.03em] text-slate-950">{{ $perlombaan->nama_lomba }}</h3>
                        <p class="mt-4 text-sm leading-7 text-slate-600">{{ \Illuminate\Support\Str::limit($perlombaan->deskripsi, 120) }}</p>

                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Peserta</p>
                                <p class="mt-2 text-2xl font-black text-slate-950">{{ $perlombaan->pendaftarans_count }}</p>
                            </div>
                            <div class="rounded-2xl bg-sky-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-sky-700">Kriteria</p>
                                <p class="mt-2 text-2xl font-black text-slate-950">{{ $perlombaan->kriterias_count }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col gap-3">
                            <a href="{{ route('juri.penilaian.submissions', $perlombaan) }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                Lihat Submission
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </a>
                            @if ($perlombaan->resultsAreVisible())
                                <a href="{{ route('juri.penilaian.results', $perlombaan) }}" class="inline-flex items-center justify-center rounded-2xl border border-amber-200 bg-amber-50 px-5 py-3 text-sm font-bold text-amber-700 transition hover:bg-amber-100">
                                    Lihat Hasil & Podium
                                </a>
                            @endif
                            <p class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3 text-center text-sm font-medium text-slate-500">
                                Kriteria ditetapkan admin dan bisa kamu lihat di form penilaian.
                            </p>
                        </div>
                    </article>
                @empty
                    <div class="rounded-[2rem] border border-dashed border-slate-300 bg-white p-8 text-sm text-slate-500 lg:col-span-2 xl:col-span-3">
                        Belum ada perlombaan yang di-assign ke akun juri ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
