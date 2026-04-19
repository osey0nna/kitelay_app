<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Peserta Dashboard</p>
                <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Detail Lomba</h2>
                <p class="max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">{{ $perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('peserta.lomba.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                Kembali ke Katalog
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8">
            <x-page-hero
                eyebrow="Persiapan Peserta"
                :title="$perlombaan->nama_lomba"
                description="Baca detail lomba dan rundown lengkap di halaman ini terlebih dahulu. Setelah itu baru lanjutkan pendaftaran agar alurnya lebih jelas dan terstruktur."
                accent="orange"
            >
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Status</p>
                        <p class="mt-3 text-xl font-black tracking-[-0.04em] text-slate-950">{{ str($perlombaan->status)->replace('_', ' ')->title() }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Kriteria</p>
                        <p class="mt-3 text-3xl font-black tracking-[-0.04em] text-slate-950">{{ $perlombaan->kriterias_count }}</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Sisa Kuota</p>
                        <p class="mt-3 text-3xl font-black tracking-[-0.04em] text-slate-950">{{ $participantsRemaining ?? 'Unlimited' }}</p>
                    </div>
                </div>
            </x-page-hero>

            <section class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Tentang Lomba</p>
                    <h3 class="mt-3 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Peserta perlu membaca detail ini sebelum mendaftar.</h3>
                    <p class="mt-5 text-sm leading-8 text-slate-600 sm:text-base">{{ $perlombaan->deskripsi }}</p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Juri Terlibat</p>
                            <p class="mt-3 text-3xl font-black tracking-[-0.04em] text-slate-950">{{ $perlombaan->juris_count }}</p>
                            <p class="mt-3 text-sm leading-7 text-slate-500">{{ $perlombaan->juris->pluck('name')->join(', ') ?: 'Belum ada juri yang di-assign.' }}</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Peserta Terdaftar</p>
                            <p class="mt-3 text-3xl font-black tracking-[-0.04em] text-slate-950">{{ $perlombaan->pendaftarans_count }}</p>
                            <p class="mt-3 text-sm leading-7 text-slate-500">Pantau kapasitas lomba dan pastikan kamu mendaftar sebelum kuota penuh.</p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <p class="text-[11px] font-black uppercase tracking-[0.28em] text-orange-500">Aksi Peserta</p>
                    <h3 class="mt-3 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Setelah membaca detail, baru lanjut daftar.</h3>

                    <div class="mt-6 space-y-4">
                        @if ($existingRegistration)
                            <div class="rounded-[1.5rem] border border-emerald-200 bg-emerald-50 p-5">
                                <p class="text-[11px] font-black uppercase tracking-[0.18em] text-emerald-700">Status Pendaftaran</p>
                                <p class="mt-3 text-xl font-black tracking-[-0.03em] text-emerald-800">Kamu sudah terdaftar di lomba ini.</p>
                                <p class="mt-3 text-sm leading-7 text-emerald-700">Lanjutkan ke submission kalau sudah siap mengunggah karya.</p>
                            </div>

                            <a href="{{ route('peserta.lomba.edit', $existingRegistration) }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                {{ $existingRegistration->submitted_at ? 'Edit Submission' : 'Isi Submission' }}
                            </a>
                        @else
                            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
                                <p class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Checklist Singkat</p>
                                <ul class="mt-3 space-y-2 text-sm leading-7 text-slate-600">
                                    <li>Pastikan kamu sudah membaca deskripsi dan tujuan lomba.</li>
                                    <li>Cek semua bobot penilaian agar submission lebih terarah.</li>
                                    <li>Perhatikan rundown dan tanggal penting sebelum mendaftar.</li>
                                </ul>
                            </div>

                            <form method="POST" action="{{ route('peserta.lomba.register', $perlombaan) }}">
                                @csrf
                                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                    Daftar Lomba Ini
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            </section>

            <section class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
                <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Kriteria Penilaian</p>
                    <h3 class="mt-3 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Fokus nilai yang akan dilihat juri.</h3>

                    <div class="mt-6 space-y-4">
                        @forelse ($perlombaan->kriterias as $kriteria)
                            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-lg font-black tracking-[-0.03em] text-slate-950">{{ $kriteria->nama_kriteria }}</p>
                                        <p class="mt-2 text-sm leading-7 text-slate-600">{{ $kriteria->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}</p>
                                    </div>
                                    <span class="inline-flex rounded-full bg-white px-3 py-1 text-[10px] font-black uppercase tracking-[0.14em] text-slate-700 ring-1 ring-slate-200">
                                        Bobot {{ $kriteria->bobot }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">
                                Kriteria lomba belum disiapkan admin.
                            </div>
                        @endforelse
                    </div>
                </article>

                <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <p class="text-[11px] font-black uppercase tracking-[0.28em] text-orange-500">Rundown Lomba</p>
                    <h3 class="mt-3 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Urutan jadwal penting yang perlu kamu pantau.</h3>

                    <div class="mt-8 space-y-5">
                        @forelse ($rundown as $index => $item)
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-950 text-sm font-black text-white">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    @if (! $loop->last)
                                        <span class="mt-2 h-full w-px bg-slate-200"></span>
                                    @endif
                                </div>
                                <div class="pb-5">
                                    <p class="text-lg font-black tracking-[-0.03em] text-slate-950">{{ $item['label'] }}</p>
                                    <p class="mt-2 text-sm font-semibold text-sky-700">{{ $item['datetime']->translatedFormat('d M Y H:i') }}</p>
                                    <p class="mt-2 text-sm leading-7 text-slate-600">{{ $item['description'] }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">
                                Rundown belum tersedia untuk lomba ini.
                            </div>
                        @endforelse
                    </div>
                </article>
            </section>
        </div>
    </div>
</x-app-layout>
