<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Admin Panel</p>
                <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Assignment Juri</h2>
                <p class="mt-1 max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">{{ $perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('admin.perlombaan.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                Kembali ke Perlombaan
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-3">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Juri Tersedia</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ $availableJuries->count() }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Juri Ditugaskan</p>
                    <p class="mt-3 text-4xl font-black tabular-nums tracking-[-0.04em] text-slate-950">{{ count($assignedIds) }}</p>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">Kondisi</p>
                    <p class="mt-3 text-lg font-black {{ count($assignedIds) > 0 ? 'text-emerald-600' : 'text-orange-500' }}">
                        {{ count($assignedIds) > 0 ? 'Siap untuk penilaian' : 'Belum ada juri assigned' }}
                    </p>
                </div>
            </section>

            <form method="POST" action="{{ route('admin.perlombaan.juri.update', $perlombaan) }}" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-orange-500">Pilih Juri</p>
                        <h3 class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-950 sm:text-3xl">Tentukan siapa saja yang boleh menilai perlombaan ini.</h3>
                    </div>
                </div>

                <x-input-error :messages="$errors->get('juri_ids')" class="mt-4" />
                <x-input-error :messages="$errors->get('juri_ids.*')" class="mt-2" />

                <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($availableJuries as $juri)
                        <label class="flex cursor-pointer items-start gap-4 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5 transition hover:border-sky-300 hover:bg-sky-50/50">
                            <input type="checkbox" name="juri_ids[]" value="{{ $juri->id }}" @checked(in_array($juri->id, old('juri_ids', $assignedIds), true)) class="mt-1 h-5 w-5 rounded border-slate-300 text-slate-950 focus:ring-slate-950">
                            <div>
                                <p class="text-lg font-black tracking-[-0.03em] text-slate-950">{{ $juri->name }}</p>
                                <p class="mt-1 text-sm leading-7 text-slate-500">{{ $juri->email }}</p>
                                <p class="mt-3 text-[11px] font-black uppercase tracking-[0.18em] text-sky-700">Sudah assigned ke {{ $juri->lomba_dinilai_count }} lomba</p>
                            </div>
                        </label>
                    @empty
                        <div class="rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 p-8 text-sm text-slate-500 md:col-span-2 xl:col-span-3">
                            Belum ada user dengan role juri. Tambahkan akun juri dulu agar assignment bisa dilakukan.
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm leading-7 text-slate-500">Setelah assignment juri selesai, penilaian akan mengikuti daftar juri aktif yang kamu tetapkan di sini.</p>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                        Simpan Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
