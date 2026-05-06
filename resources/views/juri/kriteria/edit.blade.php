<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-orange-500">Juri Workspace</p>
            <h2 class="text-2xl font-bold text-white">Edit Kriteria</h2>
            <p class="mt-1 text-sm text-slate-300">{{ $perlombaan->nama_lomba }}</p>
        </div>
    </x-slot>

    <div class="bg-black py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('juri.kriteria.update', [$perlombaan, $kriteria]) }}" class="rounded-[2rem] border border-neutral-800 bg-[#0a0a0c] p-6 shadow-2xl sm:p-8">
                @csrf
                @method('PUT')

                @include('juri.kriteria._form', [
                    'submitLabel' => 'Update Kriteria',
                ])
            </form>
        </div>
    </div>
</x-app-layout>
