<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Admin Panel</p>
                <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Kriteria Penilaian</h2>
                <p class="mt-1 max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">{{ $perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('admin.perlombaan.kriteria.create', $perlombaan) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                Tambah Kriteria
                <span class="material-symbols-outlined text-base">add</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-3">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Total Kriteria</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $kriterias->count() }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Total Bobot</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] {{ $totalBobot === 100 ? 'text-emerald-600' : 'text-slate-950' }}">{{ $totalBobot }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Status Validasi</p>
                    <p class="mt-3 text-lg font-black {{ $totalBobot === 100 ? 'text-emerald-600' : 'text-orange-500' }}">
                        {{ $totalBobot === 100 ? 'Bobot sudah ideal' : 'Cek kembali total bobot' }}
                    </p>
                </div>
            </section>

            <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Urutan</th>
                                <th class="px-6 py-4">Kriteria</th>
                                <th class="px-6 py-4">Bobot</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700">
                            @forelse ($kriterias as $kriteria)
                                <tr>
                                    <td class="px-6 py-5 align-top text-lg font-black tabular-nums tracking-[-0.03em] text-slate-950">{{ $kriteria->urutan }}</td>
                                    <td class="px-6 py-5 align-top">
                                        <p class="text-lg font-black tracking-[-0.03em] text-slate-950">{{ $kriteria->nama_kriteria }}</p>
                                        <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-500">{{ $kriteria->deskripsi ?: 'Belum ada deskripsi.' }}</p>
                                    </td>
                                    <td class="px-6 py-5 align-top text-lg font-black tabular-nums tracking-[-0.03em] text-slate-900">{{ $kriteria->bobot }}</td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.perlombaan.kriteria.edit', [$perlombaan, $kriteria]) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.perlombaan.kriteria.destroy', [$perlombaan, $kriteria]) }}" onsubmit="return confirm('Hapus kriteria ini?')">
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
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">
                                        Belum ada kriteria untuk perlombaan ini. Tambahkan kriteria pertama agar juri nanti bisa mulai menilai peserta.
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
