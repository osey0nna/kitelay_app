<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Juri Workspace</p>
                <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Hasil & Podium Lomba</h2>
                <p class="mt-1 max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">{{ $perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('juri.penilaian.submissions', $perlombaan) }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                Kembali ke Submission
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <x-page-hero
                eyebrow="Hasil Akhir"
                title="Podium dan ranking final yang sudah dipublikasikan admin."
                description="Halaman ini bersifat baca saja, supaya juri bisa ikut memantau hasil akhir setelah pengumuman resmi dibuka."
                accent="orange"
            >
                <div class="flex flex-wrap gap-3">
                    <a href="#podium" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                        Lihat Podium
                    </a>
                    <a href="#ranking" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                        Lihat Ranking Lengkap
                    </a>
                </div>

                <div class="mt-4 rounded-[1.75rem] border border-white/70 bg-white/85 p-4 shadow-sm backdrop-blur">
                    <p class="text-[11px] font-black uppercase tracking-[0.2em] text-orange-600">Catatan Juri</p>
                    <p class="mt-3 text-base font-semibold leading-8 text-slate-700">
                        Halaman ini hanya menampilkan hasil final yang sudah resmi dibuka admin. Juri tetap tidak mengubah podium dari sini, hanya memantau hasil akhir lomba.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Ranking Final</p>
                        <p class="mt-3 text-3xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $rankedRegistrations->count() }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Podium</p>
                        <p class="mt-3 text-3xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $podium->count() }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Status</p>
                        <p class="mt-3 text-lg font-black text-emerald-700">Sudah Dipublikasikan</p>
                    </div>
                </div>
            </x-page-hero>

            <section id="podium" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-orange-500">Podium</p>
                        <h3 class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Tiga peserta terbaik yang sudah diumumkan.</h3>
                    </div>
                    <p class="max-w-xl text-sm leading-7 text-slate-500">Gunakan bagian ini untuk cek cepat siapa juara 1 sampai 3 setelah hasil final dibuka oleh admin.</p>
                </div>

                <div class="mt-8 grid gap-5 lg:grid-cols-3">
                    @forelse ($podium as $participant)
                        <article class="rounded-[2rem] border p-6 shadow-sm {{ $loop->iteration === 1 ? 'border-amber-200 bg-gradient-to-br from-amber-50 via-white to-amber-100/60' : ($loop->iteration === 2 ? 'border-slate-300 bg-gradient-to-br from-slate-100 to-white' : 'border-orange-200 bg-gradient-to-br from-orange-50 to-white') }}">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[11px] font-black uppercase tracking-[0.18em] {{ $loop->iteration === 1 ? 'text-amber-600' : ($loop->iteration === 2 ? 'text-slate-500' : 'text-orange-500') }}">
                                        Juara {{ $participant->ranking_position }}
                                    </p>
                                    <p class="mt-3 text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                        {{ $loop->iteration === 1 ? 'Nilai Tertinggi' : ($loop->iteration === 2 ? 'Posisi Kedua' : 'Posisi Ketiga') }}
                                    </p>
                                </div>
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl font-black text-slate-950 shadow-sm ring-1 ring-black/5">
                                    {{ $participant->ranking_position }}
                                </span>
                            </div>
                            <h4 class="mt-6 text-2xl font-black tracking-[-0.03em] text-slate-950">{{ $participant->user->name }}</h4>
                            <p class="mt-2 text-sm leading-7 text-slate-500">{{ $participant->submission_title ?: 'Belum ada judul submission' }}</p>
                            <div class="mt-6 rounded-[1.5rem] bg-white/90 p-4 ring-1 ring-black/5">
                                <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-400">Skor Final</p>
                                <p class="mt-2 text-5xl font-black tabular-nums tracking-[-0.05em] text-slate-950">{{ number_format((float) $participant->final_score, 2) }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-[1.75rem] border border-dashed border-slate-300 bg-slate-50 p-8 text-sm text-slate-500 lg:col-span-3">
                            Belum ada podium yang bisa ditampilkan.
                        </div>
                    @endforelse
                </div>
            </section>

            <section id="ranking" class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-sky-600">Ranking Lengkap</p>
                    <h3 class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-950">Daftar lengkap peserta yang sudah punya skor final.</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Rank</th>
                                <th class="px-6 py-4">Peserta</th>
                                <th class="px-6 py-4">Submission</th>
                                <th class="px-6 py-4">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700">
                            @forelse ($rankedRegistrations as $registration)
                                <tr>
                                    <td class="px-6 py-5 align-top text-base font-black tabular-nums tracking-[-0.03em] text-slate-950">#{{ $registration->ranking_position }}</td>
                                    <td class="px-6 py-5 align-top">
                                        <p class="text-lg font-black tracking-[-0.03em] text-slate-900">{{ $registration->user->name }}</p>
                                    </td>
                                    <td class="px-6 py-5 align-top text-sm leading-7 text-slate-500">{{ $registration->submission_title ?: 'Belum ada judul submission' }}</td>
                                    <td class="px-6 py-5 align-top text-base font-black tabular-nums tracking-[-0.03em] text-slate-900">{{ number_format((float) $registration->final_score, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada ranking final yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
