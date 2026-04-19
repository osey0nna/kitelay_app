<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-600">Juri Workspace</p>
                <h2 class="text-2xl font-bold text-slate-900">Form Penilaian Peserta</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $perlombaan->nama_lomba }} - {{ $pendaftaran->user->name }}</p>
            </div>
            <a href="{{ route('juri.penilaian.submissions', $perlombaan) }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Peserta</p>
                        <p class="mt-2 text-xl font-black text-slate-950">{{ $pendaftaran->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-500">Judul Submission</p>
                        <p class="mt-2 text-xl font-black text-slate-950">{{ $pendaftaran->submission_title ?: 'Belum ada judul' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-500">File Hasil</p>
                        @if ($pendaftaran->submission_file_url)
                            <div class="mt-2 flex flex-col gap-2">
                                <p class="text-sm font-medium text-slate-700">{{ $pendaftaran->submission_file_name }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @if ($pendaftaran->submission_file_is_previewable)
                                        <a href="{{ route('juri.penilaian.file.show', [$perlombaan, $pendaftaran]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-xl bg-sky-600 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-white transition hover:bg-sky-700">
                                            Lihat File
                                        </a>
                                    @endif
                                    <a href="{{ route('juri.penilaian.file.download', [$perlombaan, $pendaftaran]) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                                        Unduh
                                    </a>
                                </div>
                                @unless ($pendaftaran->submission_file_is_previewable)
                                    <p class="text-xs leading-6 text-amber-700">Format file ini tidak mendukung preview langsung di browser. Silakan unduh lalu buka dengan aplikasi terkait.</p>
                                @endunless
                            </div>
                        @else
                            <p class="mt-2 text-sm font-medium text-slate-700">{{ $pendaftaran->file_hasil ?: 'Belum ada file' }}</p>
                        @endif
                    </div>
                </div>

                <p class="mt-5 text-sm leading-7 text-slate-600">{{ $pendaftaran->submission_notes ?: 'Belum ada catatan submission.' }}</p>
            </section>

            <form method="POST" action="{{ route('juri.penilaian.update', [$perlombaan, $pendaftaran]) }}" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    @foreach ($perlombaan->kriterias as $index => $kriteria)
                        @php
                            $existing = $existingScores->get($kriteria->id);
                        @endphp
                        <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                            <input type="hidden" name="scores[{{ $index }}][kriteria_id]" value="{{ $kriteria->id }}">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Bobot {{ $kriteria->bobot }}</p>
                                    <h3 class="mt-2 text-xl font-black text-slate-950">{{ $kriteria->nama_kriteria }}</h3>
                                    <p class="mt-2 text-sm leading-7 text-slate-600">{{ $kriteria->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}</p>
                                </div>
                                <div class="w-full sm:w-40">
                                    <x-input-label for="scores_{{ $index }}_skor" value="Skor 0-100" />
                                    <x-text-input id="scores_{{ $index }}_skor" name="scores[{{ $index }}][skor]" type="number" min="0" max="100" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('scores.'.$index.'.skor', $existing?->skor)" required />
                                    <x-input-error :messages="$errors->get('scores.'.$index.'.skor')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="scores_{{ $index }}_catatan" value="Catatan Juri" />
                                <textarea id="scores_{{ $index }}_catatan" name="scores[{{ $index }}][catatan]" rows="3" class="mt-2 block w-full rounded-2xl border-slate-200 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('scores.'.$index.'.catatan', $existing?->catatan) }}</textarea>
                                <x-input-error :messages="$errors->get('scores.'.$index.'.catatan')" class="mt-2" />
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm leading-7 text-slate-500">Nilai yang disimpan di tahap ini akan memperbarui skor akhir submission berdasarkan bobot kriteria yang tersedia.</p>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                        Simpan Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
