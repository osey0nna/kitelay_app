<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-600">Juri Workspace</p>
                <h2 class="text-2xl font-bold text-slate-900">Daftar Submission Peserta</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('juri.penilaian.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            @if ($perlombaan->resultsAreVisible())
                <div class="flex justify-end">
                    <a href="{{ route('juri.penilaian.results', $perlombaan) }}" class="inline-flex items-center justify-center rounded-2xl border border-amber-200 bg-amber-50 px-5 py-3 text-sm font-bold text-amber-700 transition hover:bg-amber-100">
                        Lihat Hasil & Podium
                    </a>
                </div>
            @endif

            <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-[0.18em] text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Peserta</th>
                                <th class="px-6 py-4">Submission</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Dinilai</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700">
                            @forelse ($pendaftarans as $pendaftaran)
                                <tr>
                                    <td class="px-6 py-5 align-top">
                                        <p class="font-bold text-slate-950">{{ $pendaftaran->user->name }}</p>
                                        <p class="mt-1 text-sm text-slate-500">{{ $pendaftaran->user->email }}</p>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <p class="font-semibold text-slate-900">{{ $pendaftaran->submission_title ?: 'Belum ada judul submission' }}</p>
                                        <p class="mt-2 max-w-md text-sm leading-6 text-slate-500">{{ $pendaftaran->submission_notes ?: 'Belum ada catatan submission.' }}</p>
                                        @if ($pendaftaran->hasStoredSubmissionFile())
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                @if ($pendaftaran->submission_file_is_previewable)
                                                    <a href="{{ route('juri.penilaian.file.show', [$perlombaan, $pendaftaran]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-xl bg-sky-600 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-white transition hover:bg-sky-700">
                                                        Lihat File
                                                    </a>
                                                @endif
                                                <a href="{{ route('juri.penilaian.file.download', [$perlombaan, $pendaftaran]) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                                                    Unduh File
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <span class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-xs font-bold uppercase tracking-[0.16em] text-sky-700">
                                            {{ str($pendaftaran->status)->replace('_', ' ')->title() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 align-top font-semibold text-slate-900">{{ $pendaftaran->scored_items_count }}</td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex justify-end">
                                            <a href="{{ route('juri.penilaian.edit', [$perlombaan, $pendaftaran]) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                                                Nilai Peserta
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">
                                        Belum ada peserta atau submission untuk perlombaan ini.
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
