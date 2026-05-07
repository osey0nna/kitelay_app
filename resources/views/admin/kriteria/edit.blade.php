<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[11px] font-black uppercase tracking-[0.28em] text-orange-500">Admin Panel</p>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-black tracking-[-0.04em] text-slate-950">Edit Kriteria</h2>
            <p class="mt-1 max-w-2xl text-xs md:text-sm leading-7 text-slate-500">{{ $perlombaan->nama_lomba }}</p>
        </div>
    </x-slot>

    <div class="py-6 md:py-10">
        <div class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.perlombaan.kriteria.update', [$perlombaan, $kriteria]) }}" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                @csrf
                @method('PUT')

                @include('admin.kriteria._form', [
                    'submitLabel' => 'Update Kriteria',
                ])
            </form>
        </div>
    </div>
</x-app-layout>
