<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-orange-500">Juri Workspace</p>
            <h2 class="text-2xl font-bold text-slate-900">Edit Kriteria</h2>
            <p class="mt-1 text-sm text-slate-500">{{ $perlombaan->nama_lomba }}</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('juri.kriteria.update', [$perlombaan, $kriteria]) }}" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                @csrf
                @method('PUT')

                @include('juri.kriteria._form', [
                    'submitLabel' => 'Update Kriteria',
                ])
            </form>
        </div>
    </div>
</x-app-layout>
