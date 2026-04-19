<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Admin Panel</p>
            <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Tambah Kriteria</h2>
            <p class="mt-1 max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">{{ $perlombaan->nama_lomba }}</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.perlombaan.kriteria.store', $perlombaan) }}" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                @csrf

                @include('admin.kriteria._form', [
                    'submitLabel' => 'Simpan Kriteria',
                ])
            </form>
        </div>
    </div>
</x-app-layout>
