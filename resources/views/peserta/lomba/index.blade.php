<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Peserta Dashboard</p>
            <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Katalog Lomba</h2>
            <p class="max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">Pilih lomba yang ingin kamu ikuti, lalu pantau submission dan hasilnya dari satu halaman yang rapi.</p>
        </div>
    </x-slot>

    @php
        $registeredCount = $myRegistrations->count();
        $submittedCount = $myRegistrations->whereIn('status', [\App\Models\Pendaftaran::STATUS_SUBMITTED, \App\Models\Pendaftaran::STATUS_REVIEWED])->count();
        $reviewedCount = $myRegistrations->where('status', \App\Models\Pendaftaran::STATUS_REVIEWED)->count();
        $visibleResultsCount = $myRegistrations->filter(fn ($registration) => $registration->status === \App\Models\Pendaftaran::STATUS_REVIEWED && $registration->perlombaan->resultsAreVisible())->count();
    @endphp

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8">
            <x-page-hero
                eyebrow="Lomba Tersedia"
                title="Pilih lomba yang ingin kamu ikuti."
                description="Setelah mendaftar, kamu bisa langsung melengkapi submission, upload file hasil, dan memantau nilai dari dashboard peserta."
                accent="orange"
            >
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Lomba Tersedia</p>
                        <p class="mt-3 text-3xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $availableCompetitions->count() }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Sudah Diikuti</p>
                        <p class="mt-3 text-3xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $registeredCount }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Sudah Dinilai</p>
                        <p class="mt-3 text-3xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $reviewedCount }}</p>
                    </div>
                </div>
            </x-page-hero>

            <section class="grid gap-4 md:grid-cols-3">
                <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Pendaftaran Saya</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $registeredCount }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-500">Jumlah lomba yang sudah kamu ikuti sampai saat ini.</p>
                </article>
                <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Submission Masuk</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-orange-500">{{ $submittedCount }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-500">Submission yang sudah kamu kirim dan sedang menunggu hasil atau sudah dinilai.</p>
                </article>
                <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Hasil Tersedia</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-emerald-600">{{ $visibleResultsCount }}</p>
                    <p class="mt-3 text-sm leading-7 text-slate-500">Jumlah lomba yang hasil dan podiumnya sudah resmi dibuka untuk peserta.</p>
                </article>
            </section>

            <section>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Eksplorasi</p>
                        <h3 class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Lomba yang masih terbuka untuk peserta.</h3>
                    </div>
                    <p class="max-w-xl text-sm leading-7 text-slate-500">Buka detail lomba terlebih dahulu untuk membaca rundown, kriteria, dan jadwal penting sebelum mendaftar.</p>
                </div>

                <div class="mt-6 grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
                    @forelse ($availableCompetitions as $competition)
                        <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="flex items-start justify-between gap-4">
                                <span class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-[10px] font-black uppercase tracking-[0.16em] text-sky-700">{{ str($competition->status)->replace('_', ' ')->title() }}</span>
                                <span class="text-xs font-semibold text-slate-400">{{ optional($competition->registration_end_at)->translatedFormat('d M Y') ?? optional($competition->deadline_pendaftaran)->translatedFormat('d M Y') ?? '-' }}</span>
                            </div>

                            <h3 class="mt-4 text-2xl font-black tracking-[-0.04em] text-slate-950">{{ $competition->nama_lomba }}</h3>
                            <p class="mt-4 text-sm leading-7 text-slate-600">{{ \Illuminate\Support\Str::limit($competition->deskripsi, 140) }}</p>

                            <div class="mt-6 grid grid-cols-3 gap-3">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-[11px] font-black uppercase tracking-[0.16em] text-slate-400">Kriteria</p>
                                    <p class="mt-2 text-2xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $competition->kriterias_count }}</p>
                                </div>
                                <div class="rounded-2xl bg-sky-50 p-4">
                                    <p class="text-[11px] font-black uppercase tracking-[0.16em] text-sky-700">Juri</p>
                                    <p class="mt-2 text-2xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $competition->juris_count }}</p>
                                </div>
                                <div class="rounded-2xl bg-emerald-50 p-4">
                                    <p class="text-[11px] font-black uppercase tracking-[0.16em] text-emerald-700">Peserta</p>
                                    <p class="mt-2 text-2xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $competition->pendaftarans_count }}</p>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-[11px] font-black uppercase tracking-[0.16em] text-slate-400">Deadline Pendaftaran</p>
                                    <p class="mt-1 text-sm font-semibold text-slate-600">{{ optional($competition->registration_end_at)->translatedFormat('d M Y') ?? optional($competition->deadline_pendaftaran)->translatedFormat('d M Y') ?? '-' }}</p>
                                </div>

                                <div class="flex flex-col items-start gap-3 sm:items-end">
                                    @if (in_array($competition->id, $registeredCompetitionIds, true))
                                        <span class="inline-flex rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">Sudah Terdaftar</span>
                                    @endif

                                    <a href="{{ route('peserta.lomba.show', $competition) }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                        {{ in_array($competition->id, $registeredCompetitionIds, true) ? 'Lihat Detail' : 'Detail & Rundown' }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-[2rem] border border-dashed border-slate-300 bg-white p-8 text-sm text-slate-500 lg:col-span-2 xl:col-span-3">
                            Belum ada lomba yang tersedia untuk peserta.
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Lomba Saya</p>
                        <h3 class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Riwayat pendaftaran dan submission kamu.</h3>
                    </div>
                    <p class="max-w-xl text-sm leading-7 text-slate-500">Dari sini kamu bisa cek status, lengkapi submission, dan melihat hasil hanya setelah jadwal pengumuman dibuka.</p>
                </div>

                <div class="mt-8 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">
                            <tr>
                                <th class="px-5 py-4">Perlombaan</th>
                                <th class="px-5 py-4">Status</th>
                                <th class="px-5 py-4">Submission</th>
                                <th class="px-5 py-4">Nilai Akhir</th>
                                <th class="px-5 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($myRegistrations as $registration)
                                <tr>
                                    <td class="px-5 py-5 align-top">
                                        <p class="text-lg font-black tracking-[-0.03em] text-slate-950">{{ $registration->perlombaan->nama_lomba }}</p>
                                        <p class="mt-1 text-sm leading-7 text-slate-500">{{ $registration->submission_title ?: 'Belum ada submission' }}</p>
                                    </td>
                                    <td class="px-5 py-5 align-top">
                                        <span class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-[10px] font-black uppercase tracking-[0.16em] text-sky-700">
                                            {{ str($registration->status)->replace('_', ' ')->title() }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 align-top text-sm leading-7 text-slate-500">
                                        {{ $registration->submitted_at?->translatedFormat('d M Y H:i') ?? 'Belum submit' }}
                                    </td>
                                    <td class="px-5 py-5 align-top text-base font-black tabular-nums tracking-[-0.03em] text-slate-900">
                                        @if ($registration->final_score !== null && $registration->perlombaan->resultsAreVisible())
                                            {{ number_format((float) $registration->final_score, 2) }}
                                        @elseif ($registration->final_score !== null)
                                            <span class="text-sm font-bold tracking-normal text-amber-700">Menunggu Pengumuman</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-5 py-5 align-top">
                                        <div class="flex justify-end gap-3">
                                            @if ($registration->final_score !== null && $registration->perlombaan->resultsAreVisible())
                                                <a href="{{ route('peserta.lomba.results', $registration) }}" class="inline-flex items-center justify-center rounded-xl border border-amber-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-amber-700 transition hover:bg-amber-50">
                                                    Lihat Hasil
                                                </a>
                                            @elseif ($registration->final_score !== null)
                                                <span class="inline-flex items-center justify-center rounded-xl border border-amber-200 bg-amber-50 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.14em] text-amber-700">
                                                    Menunggu Pengumuman
                                                </span>
                                            @endif
                                            <a href="{{ route('peserta.lomba.edit', $registration) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                                                {{ $registration->submitted_at ? 'Edit Submission' : 'Isi Submission' }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">Kamu belum mendaftar ke lomba mana pun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
