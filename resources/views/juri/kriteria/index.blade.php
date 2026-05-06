<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-orange-500">Juri Workspace</p>
                <h2 class="text-2xl font-bold text-white">Kelola Kriteria</h2>
                <p class="mt-1 text-sm text-slate-300">{{ $perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('juri.penilaian.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-neutral-700 bg-[#0a0a0c] px-5 py-3 text-sm font-bold text-white transition hover:border-amber-400 hover:text-white">
                Kembali ke Daftar Lomba
            </a>
        </div>
    </x-slot>

    <div class="bg-black py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-3">
                <div class="rounded-[1.75rem] border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl">
                    <p class="text-sm font-semibold text-slate-400">Total Kriteria</p>
                    <p class="mt-3 text-4xl font-black tracking-[-0.04em] text-white">{{ $kriterias->count() }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl">
                    <p class="text-sm font-semibold text-slate-400">Total Bobot</p>
                    <p class="mt-3 text-4xl font-black tracking-[-0.04em] {{ $totalBobot === 100 ? 'text-emerald-400' : 'text-white' }}">{{ $totalBobot }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl">
                    <p class="text-sm font-semibold text-slate-400">Status Validasi</p>
                    <p class="mt-3 text-lg font-black {{ $totalBobot === 100 ? 'text-emerald-400' : 'text-orange-400' }}">
                        {{ $totalBobot === 100 ? 'Bobot sudah ideal' : 'Cek kembali total bobot' }}
                    </p>
                </div>
            </section>

            <section class="overflow-hidden rounded-[2rem] border border-neutral-800 bg-[#0a0a0c] shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-800 text-sm">
                        <thead class="bg-[#050505] text-left text-xs font-bold uppercase tracking-[0.18em] text-slate-400">
                            <tr>
                                <th class="px-6 py-4">Urutan</th>
                                <th class="px-6 py-4">Kriteria</th>
                                <th class="px-6 py-4">Bobot</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800 bg-[#0a0a0c] text-slate-200">
                            @forelse ($kriterias as $kriteria)
                                <tr class="hover:bg-[#050505] transition-colors">
                                    <td class="px-6 py-5 align-top font-bold text-white">{{ $kriteria->urutan }}</td>
                                    <td class="px-6 py-5 align-top">
                                        <p class="font-bold text-white">{{ $kriteria->nama_kriteria }}</p>
                                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">{{ $kriteria->deskripsi ?: 'Belum ada deskripsi.' }}</p>
                                    </td>
                                    <td class="px-6 py-5 align-top font-semibold text-white">{{ $kriteria->bobot }}</td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('juri.kriteria.edit', [$perlombaan, $kriteria]) }}" class="inline-flex items-center justify-center rounded-xl border border-neutral-700 bg-black px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-white transition hover:border-amber-400 hover:text-white">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('juri.kriteria.destroy', [$perlombaan, $kriteria]) }}" onsubmit="return confirm('Hapus kriteria ini? Nilai yang terkait juga akan dibersihkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-red-500/40 bg-red-900/20 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-red-300 transition hover:bg-red-700/30">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400">
                                        Belum ada kriteria untuk perlombaan ini.
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
