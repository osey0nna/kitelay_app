<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Admin Panel</p>
                <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Ranking & Podium</h2>
                <p class="mt-1 max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">{{ $perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('admin.perlombaan.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                Kembali ke Perlombaan
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-4">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Total Peserta</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $registrations->count() }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Sudah Dinilai</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $rankedRegistrations->count() }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Rata-rata Nilai</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $averageScore }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Status Pengumuman</p>
                    <p class="mt-3 text-lg font-black {{ $perlombaan->resultsArePubliclyVisible() ? 'text-emerald-600' : ($perlombaan->resultsHaveBeenReleased() ? ($perlombaan->announcementTimeHasArrived() ? 'text-sky-700' : 'text-amber-600') : ($podium->isNotEmpty() ? 'text-orange-500' : 'text-slate-500')) }}">
                        {{ $perlombaan->resultsArePubliclyVisible() ? 'Sudah terlihat oleh peserta, juri, dan publik' : ($perlombaan->resultsHaveBeenReleased() ? ($perlombaan->announcementTimeHasArrived() ? 'Riwayat internal aktif, publik sedang ditutup' : 'Sudah dirilis, menunggu jam pengumuman') : ($podium->isNotEmpty() ? 'Siap dipublikasikan' : 'Belum ada hasil final')) }}
                    </p>
                    <p class="mt-2 text-sm leading-7 text-slate-500">
                        @if ($perlombaan->results_released_at)
                            Riwayat hasil internal dibuka pada {{ $perlombaan->results_released_at->translatedFormat('d M Y H:i') }}.
                            @if ($perlombaan->results_published_at)
                                Publik aktif sejak {{ $perlombaan->results_published_at->translatedFormat('d M Y H:i') }}.
                            @else
                                Publik saat ini sedang ditutup.
                            @endif
                            @if ($perlombaan->announcement_at)
                                Jadwal pengumuman {{ $perlombaan->announcement_at->translatedFormat('d M Y H:i') }}.
                            @endif
                        @elseif ($perlombaan->announcement_at)
                            Jadwal pengumuman: {{ $perlombaan->announcement_at->translatedFormat('d M Y H:i') }}.
                        @else
                            Jadwal pengumuman belum ditentukan.
                        @endif
                    </p>
                </div>
            </section>

            <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Kontrol Publikasi</p>
                        <h3 class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Admin memegang kendali penuh atas hasil lomba.</h3>
                        <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-500">
                            Saat admin mempublikasikan hasil, riwayat internal peserta dan juri ikut dibuka. Jika publikasi publik ditutup lagi, riwayat internal tetap ada, tetapi halaman publik langsung disembunyikan.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        @if ($perlombaan->results_published_at)
                            <form method="POST" action="{{ route('admin.perlombaan.hasil.unpublish', $perlombaan) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center rounded-2xl border border-rose-200 bg-rose-50 px-5 py-3 text-sm font-bold text-rose-700 transition hover:bg-rose-100">
                                    Tutup Publikasi Publik
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.perlombaan.hasil.publish', $perlombaan) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                    {{ $perlombaan->resultsHaveBeenReleased() ? 'Buka Lagi ke Publik' : 'Publikasikan Hasil' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </section>

            <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-orange-500">Podium</p>
                        <h3 class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Tiga peserta dengan nilai tertinggi.</h3>
                    </div>
                </div>

                <div class="mt-8 grid gap-5 lg:grid-cols-3">
                    @forelse ($podium as $participant)
                        <article class="rounded-[2rem] border border-slate-200 p-6 shadow-sm {{ $loop->first ? 'bg-gradient-to-br from-amber-50 to-white' : 'bg-white' }}">
                            <p class="text-[11px] font-black uppercase tracking-[0.18em] {{ $loop->iteration === 1 ? 'text-amber-500' : ($loop->iteration === 2 ? 'text-slate-500' : 'text-orange-500') }}">
                                Peringkat {{ $participant->ranking_position }}
                            </p>
                            <h4 class="mt-3 text-2xl font-black tracking-[-0.03em] text-slate-950">{{ $participant->user->name }}</h4>
                            <p class="mt-2 text-sm leading-7 text-slate-500">{{ $participant->submission_title ?: 'Belum ada judul submission' }}</p>
                            <p class="mt-6 text-5xl font-black tabular-nums tracking-[-0.05em] text-slate-950">{{ number_format((float) $participant->final_score, 2) }}</p>
                        </article>
                    @empty
                        <div class="rounded-[1.75rem] border border-dashed border-slate-300 bg-slate-50 p-8 text-sm text-slate-500 lg:col-span-3">
                            Belum ada peserta yang memiliki nilai final.
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Rank</th>
                                <th class="px-6 py-4">Peserta</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Nilai Akhir</th>
                                <th class="px-6 py-4">Detail Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700">
                            @forelse ($registrations as $registration)
                                <tr>
                                    <td class="px-6 py-5 align-top font-black text-slate-950">
                                        {{ $registration->final_score !== null ? $rankedRegistrations->firstWhere('id', $registration->id)?->ranking_position : '-' }}
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <p class="text-lg font-black tracking-[-0.03em] text-slate-950">{{ $registration->user->name }}</p>
                                        <p class="mt-1 text-sm leading-7 text-slate-500">{{ $registration->submission_title ?: 'Belum ada judul submission' }}</p>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <span class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-[10px] font-black uppercase tracking-[0.16em] text-sky-700">
                                            {{ str($registration->status)->replace('_', ' ')->title() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 align-top font-semibold text-slate-900">
                                        {{ $registration->final_score !== null ? number_format((float) $registration->final_score, 2) : '-' }}
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-wrap gap-2">
                                            @forelse ($registration->penilaians as $penilaian)
                                                <span class="rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-600">
                                                    {{ $penilaian->kriteria->nama_kriteria }}: {{ $penilaian->skor }}
                                                    @if ($penilaian->juri)
                                                        • {{ $penilaian->juri->name }}
                                                    @endif
                                                </span>
                                            @empty
                                                <span class="text-sm text-slate-400">Belum ada nilai.</span>
                                            @endforelse
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">
                                        Belum ada peserta di perlombaan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
