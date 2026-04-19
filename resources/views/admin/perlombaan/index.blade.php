<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Admin Panel</p>
                <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Kelola Perlombaan</h2>
                <p class="max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">Pantau struktur lomba, assignment juri, dan titik masuk ke hasil akhir dari satu meja kerja admin.</p>
            </div>
            <a href="{{ route('admin.perlombaan.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                Tambah Perlombaan
                <span class="material-symbols-outlined text-base">add</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <x-page-hero eyebrow="Ringkasan" title="Data lomba yang sudah masuk ke sistem." description="Halaman ini saya tata supaya admin bisa langsung membaca status, volume peserta, dan jalur aksi tiap lomba tanpa perlu pindah-pindah halaman dulu." accent="orange">
                <div class="inline-flex rounded-2xl bg-slate-950 px-5 py-4 text-white">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.24em] text-slate-300">Total Lomba</p>
                        <p class="mt-1 text-3xl font-black tracking-[-0.04em]">{{ $perlombaans->total() }}</p>
                    </div>
                </div>
            </x-page-hero>

            <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Perlombaan</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Peserta</th>
                                <th class="px-6 py-4">Kriteria</th>
                                <th class="px-6 py-4">Juri</th>
                                <th class="px-6 py-4">Deadline</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700">
                            @forelse ($perlombaans as $perlombaan)
                                <tr>
                                    <td class="px-6 py-5 align-top">
                                        <div>
                                            <p class="text-lg font-black tracking-[-0.03em] text-slate-950">{{ $perlombaan->nama_lomba }}</p>
                                            <p class="mt-1 text-[11px] font-black uppercase tracking-[0.16em] text-slate-400">{{ $perlombaan->slug }}</p>
                                            <p class="mt-3 max-w-md text-sm leading-7 text-slate-500">{{ \Illuminate\Support\Str::limit($perlombaan->deskripsi, 100) }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <span class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-[10px] font-black uppercase tracking-[0.16em] text-sky-700">
                                            {{ str($perlombaan->status)->replace('_', ' ')->title() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 align-top font-semibold text-slate-900">{{ $perlombaan->pendaftarans_count }}</td>
                                    <td class="px-6 py-5 align-top font-semibold text-slate-900">{{ $perlombaan->kriterias_count }}</td>
                                    <td class="px-6 py-5 align-top font-semibold text-slate-900">{{ $perlombaan->juris_count }}</td>
                                    <td class="px-6 py-5 align-top text-sm leading-7 text-slate-500">
                                        {{ optional($perlombaan->registration_end_at)->translatedFormat('d M Y') ?? optional($perlombaan->deadline_pendaftaran)->translatedFormat('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.perlombaan.hasil.show', $perlombaan) }}" class="inline-flex items-center justify-center rounded-xl border border-amber-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-amber-700 transition hover:bg-amber-50">
                                                Hasil
                                            </a>
                                            <a href="{{ route('admin.perlombaan.kriteria.index', $perlombaan) }}" class="inline-flex items-center justify-center rounded-xl border border-sky-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-sky-700 transition hover:bg-sky-50">
                                                Kriteria
                                            </a>
                                            <a href="{{ route('admin.perlombaan.juri.index', $perlombaan) }}" class="inline-flex items-center justify-center rounded-xl border border-emerald-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-emerald-700 transition hover:bg-emerald-50">
                                                Juri
                                            </a>
                                            <a href="{{ route('admin.perlombaan.edit', $perlombaan) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.perlombaan.destroy', $perlombaan) }}" onsubmit="return confirm('Hapus perlombaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-red-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-red-600 transition hover:bg-red-50">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-500">
                                        Belum ada perlombaan. Tambahkan data pertama supaya katalog lomba bisa mulai berjalan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <div>
                {{ $perlombaans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
