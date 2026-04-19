@php
    $acceptedExtensions = \App\Http\Requests\Peserta\UpdateSubmissionRequest::acceptedExtensions();
    $acceptAttribute = collect($acceptedExtensions)->map(fn ($extension) => '.'.$extension)->implode(',');
    $maxUploadMb = (int) (\App\Http\Requests\Peserta\UpdateSubmissionRequest::maxUploadKilobytes() / 1024);
    $currentFileUrl = $pendaftaran->submission_file_url;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-600">Peserta Dashboard</p>
                <h2 class="text-2xl font-bold text-slate-900">Submission Lomba</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $pendaftaran->perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('peserta.lomba.index') }}" class="inline-flex self-start items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950 sm:self-auto">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('peserta.lomba.update', $pendaftaran) }}" enctype="multipart/form-data" class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <x-input-label for="submission_title" value="Judul Submission" />
                        <x-text-input id="submission_title" name="submission_title" type="text" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('submission_title', $pendaftaran->submission_title)" required autofocus />
                        <x-input-error :messages="$errors->get('submission_title')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <x-input-label for="file_hasil" value="Upload File Hasil" />
                                <p class="mt-2 text-sm leading-7 text-slate-500">Maksimal {{ $maxUploadMb }} MB. Jika file desainmu belum didukung langsung, kompres ke `.zip` atau `.rar` lalu upload.</p>
                            </div>
                        </div>

                        <input id="file_hasil" name="file_hasil" type="file" accept="{{ $acceptAttribute }}" class="mt-3 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <x-input-error :messages="$errors->get('file_hasil')" class="mt-2" />

                        <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                            <p class="font-semibold text-slate-900">Format file yang didukung</p>
                            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Dokumen</p>
                                    <p class="mt-1 leading-7">PDF, DOC, DOCX, PPT, PPTX</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Arsip</p>
                                    <p class="mt-1 leading-7">ZIP, RAR</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Gambar / Desain</p>
                                    <p class="mt-1 leading-7">JPG, JPEG, PNG, WEBP, SVG, PSD, AI, CDR</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Video</p>
                                    <p class="mt-1 leading-7">MP4, MOV</p>
                                </div>
                            </div>
                        </div>

                        @if ($pendaftaran->file_hasil)
                            <div class="mt-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                                <p class="font-semibold text-slate-900">File saat ini</p>
                                <p class="mt-1 break-all">{{ $pendaftaran->file_hasil }}</p>
                                @if ($currentFileUrl)
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @if ($pendaftaran->submission_file_is_previewable)
                                            <a href="{{ $currentFileUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex font-semibold text-sky-700 hover:text-sky-800">
                                                Buka file saat ini
                                            </a>
                                        @endif
                                        <a href="{{ $currentFileUrl }}" download class="inline-flex font-semibold text-slate-700 hover:text-slate-900">
                                            Unduh file saat ini
                                        </a>
                                    </div>
                                    @unless ($pendaftaran->submission_file_is_previewable)
                                        <p class="mt-2 text-xs leading-6 text-amber-700">Format file ini tidak mendukung preview langsung di browser. Silakan unduh lalu buka dengan aplikasi terkait.</p>
                                    @endunless
                                @endif
                            </div>
                        @endif
                    </div>

                    <div>
                        <x-input-label for="submission_notes" value="Catatan Submission" />
                        <textarea id="submission_notes" name="submission_notes" rows="6" class="mt-2 block w-full rounded-2xl border-slate-200 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('submission_notes', $pendaftaran->submission_notes) }}</textarea>
                        <x-input-error :messages="$errors->get('submission_notes')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm leading-7 text-slate-500">File submission akan disimpan ke media penyimpanan aplikasi yang aktif. Kalau nanti ganti file, file lama akan otomatis digantikan.</p>
                    <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                        <a href="{{ route('peserta.lomba.index') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950 sm:w-auto">
                            Kembali
                        </a>
                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition hover:bg-slate-800 sm:w-auto">
                            Simpan Submission
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
