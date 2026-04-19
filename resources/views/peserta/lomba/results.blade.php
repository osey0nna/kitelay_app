<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Peserta Dashboard</p>
                <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Hasil Lomba</h2>
                <p class="mt-1 max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">{{ $pendaftaran->perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('peserta.lomba.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                Kembali
            </a>
        </div>
    </x-slot>

    @php
        $isOnPodium = $myRanking && $myRanking->ranking_position <= 3;
    @endphp

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <x-page-hero
                eyebrow="Ringkasan Hasil"
                title="Nilai akhir dan posisi kamu di perlombaan ini."
                description="Halaman ini merangkum nilai finalmu, podium juara, dan ranking lengkap peserta yang sudah diumumkan."
                accent="emerald"
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
                    <p class="text-[11px] font-black uppercase tracking-[0.2em] text-emerald-700">Status Hasil</p>
                    <p class="mt-3 text-base font-semibold leading-8 text-slate-700">
                        {{ $isOnPodium ? 'Selamat, kamu sedang ada di zona podium. Cek kartu juara di bawah untuk melihat posisi finalmu.' : 'Hasil sudah resmi dibuka. Kamu bisa cek podium di bawah dan lihat posisimu di ranking lengkap.' }}
                    </p>
                </div>

                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Nama Peserta</p>
                        <p class="mt-3 text-xl font-black tracking-[-0.03em] text-slate-950">{{ $pendaftaran->user->name }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Nilai Akhir</p>
                        <p class="mt-3 text-3xl font-black tabular-nums tracking-[-0.04em] text-emerald-700">
                            {{ $pendaftaran->final_score !== null ? number_format((float) $pendaftaran->final_score, 2) : '-' }}
                        </p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Posisi</p>
                        <p class="mt-3 text-3xl font-black tabular-nums tracking-[-0.04em] {{ $myRanking ? 'text-amber-600' : 'text-slate-950' }}">
                            {{ $myRanking ? '#'.$myRanking->ranking_position : 'Belum Diranking' }}
                        </p>
                    </div>
                </div>
            </x-page-hero>

            <section class="grid gap-4 md:grid-cols-3">
                <article class="rounded-[1.75rem] border border-slate-200 bg-gradient-to-br from-white to-slate-50 p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Jumlah Ranking</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $rankedRegistrations->count() }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-500">Total peserta yang sudah memiliki nilai akhir pada perlombaan ini.</p>
                </article>
                <article class="rounded-[1.75rem] border border-emerald-200 bg-emerald-50/70 p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Status Kamu</p>
                    <p class="mt-3 text-lg font-black {{ $isOnPodium ? 'text-amber-600' : ($pendaftaran->final_score !== null ? 'text-emerald-600' : 'text-orange-500') }}">
                        {{ $isOnPodium ? 'Masuk Podium' : ($pendaftaran->final_score !== null ? 'Sudah Dinilai' : 'Menunggu Hasil') }}
                    </p>
                    <p class="mt-3 text-sm leading-7 text-slate-500">Status ini menandakan apakah kamu sudah punya hasil final dan apakah masuk tiga besar.</p>
                </article>
                <article class="rounded-[1.75rem] border border-amber-200 bg-amber-50/70 p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Podium Tersedia</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-amber-600">{{ $podium->count() }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-500">Bagian podium ada tepat di bawah section ini dan menampilkan juara 1 sampai 3.</p>
                </article>
            </section>

            <section id="podium" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-orange-500">Podium</p>
                        <h3 class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Tiga peserta terbaik pada perlombaan ini.</h3>
                    </div>
                    <p class="max-w-xl text-sm leading-7 text-slate-500">Kalau kartu kamu disorot, berarti kamu termasuk juara pada hasil akhir yang sudah diumumkan.</p>
                </div>

                <div class="mt-8 grid gap-5 lg:grid-cols-3">
                    @forelse ($podium as $participant)
                        <article class="rounded-[2rem] border p-6 shadow-sm {{ $loop->iteration === 1 ? 'border-amber-200 bg-gradient-to-br from-amber-50 via-white to-amber-100/60' : ($loop->iteration === 2 ? 'border-slate-300 bg-gradient-to-br from-slate-100 to-white' : 'border-orange-200 bg-gradient-to-br from-orange-50 to-white') }} {{ $participant->id === $pendaftaran->id ? 'ring-2 ring-amber-300' : '' }}">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[11px] font-black uppercase tracking-[0.18em] {{ $loop->iteration === 1 ? 'text-amber-600' : ($loop->iteration === 2 ? 'text-slate-500' : 'text-orange-500') }}">
                                        Juara {{ $participant->ranking_position }}
                                    </p>
                                    @if ($participant->id === $pendaftaran->id)
                                        <span class="mt-3 inline-flex rounded-full bg-white px-3 py-1 text-[10px] font-black uppercase tracking-[0.16em] text-amber-700 ring-1 ring-amber-200">
                                            Ini Posisimu
                                        </span>
                                    @endif
                                </div>
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl font-black text-slate-950 shadow-sm ring-1 ring-black/5">
                                    {{ $participant->ranking_position }}
                                </span>
                            </div>
                            <p class="mt-6 text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                {{ $loop->iteration === 1 ? 'Nilai Tertinggi' : ($loop->iteration === 2 ? 'Posisi Kedua' : 'Posisi Ketiga') }}
                            </p>
                            <h4 class="mt-2 text-2xl font-black tracking-[-0.03em] text-slate-950">{{ $participant->user->name }}</h4>
                            <p class="mt-2 text-sm leading-7 text-slate-500">{{ $participant->submission_title ?: 'Belum ada judul submission' }}</p>
                            <div class="mt-6 rounded-[1.5rem] bg-white/90 p-4 ring-1 ring-black/5">
                                <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-400">Skor Final</p>
                                <p class="mt-2 text-5xl font-black tabular-nums tracking-[-0.05em] text-slate-950">{{ number_format((float) $participant->final_score, 2) }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-[1.75rem] border border-dashed border-slate-300 bg-slate-50 p-8 text-sm text-slate-500 lg:col-span-3">
                            Belum ada hasil penilaian yang bisa ditampilkan.
                        </div>
                    @endforelse
                </div>
            </section>

            <section id="ranking" class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-sky-600">Ranking Lengkap</p>
                    <h3 class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-950">Posisi seluruh peserta yang sudah memiliki nilai final.</h3>
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
                                <tr class="{{ $registration->id === $pendaftaran->id ? 'bg-amber-50/60' : '' }}">
                                    <td class="px-6 py-5 align-top text-base font-black tabular-nums tracking-[-0.03em] text-slate-950">#{{ $registration->ranking_position }}</td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-lg font-black tracking-[-0.03em] text-slate-900">{{ $registration->user->name }}</p>
                                            @if ($registration->id === $pendaftaran->id)
                                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-[10px] font-black uppercase tracking-[0.16em] text-amber-700">
                                                    Kamu
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-top text-sm leading-7 text-slate-500">{{ $registration->submission_title ?: 'Belum ada judul submission' }}</td>
                                    <td class="px-6 py-5 align-top text-base font-black tabular-nums tracking-[-0.03em] text-slate-900">{{ number_format((float) $registration->final_score, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada ranking yang tersedia untuk perlombaan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
