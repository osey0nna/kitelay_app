@php
    $statusLabels = [
        \App\Models\Perlombaan::STATUS_DRAFT => 'Draft',
        \App\Models\Perlombaan::STATUS_PUBLISHED => 'Published',
        \App\Models\Perlombaan::STATUS_REGISTRATION_OPEN => 'Registration Open',
        \App\Models\Perlombaan::STATUS_ONGOING => 'Ongoing',
        \App\Models\Perlombaan::STATUS_JUDGING => 'Judging',
        \App\Models\Perlombaan::STATUS_FINISHED => 'Finished',
    ];
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5 rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div>
            <x-input-label for="nama_lomba" value="Nama Perlombaan" />
            <x-text-input id="nama_lomba" name="nama_lomba" type="text" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('nama_lomba', $perlombaan->nama_lomba)" required autofocus />
            <x-input-error :messages="$errors->get('nama_lomba')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="slug" value="Slug" />
            <x-text-input id="slug" name="slug" type="text" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('slug', $perlombaan->slug)" placeholder="opsional, akan dibuat otomatis jika kosong" />
            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="deskripsi" value="Deskripsi" />
            <textarea id="deskripsi" name="deskripsi" rows="6" class="mt-2 block w-full rounded-2xl border-slate-200 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('deskripsi', $perlombaan->deskripsi) }}</textarea>
            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="mt-2 block w-full rounded-2xl border-slate-200 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status', $perlombaan->status ?: \App\Models\Perlombaan::STATUS_DRAFT) === $status)>
                        {{ $statusLabels[$status] ?? str($status)->replace('_', ' ')->title() }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    </div>

    <div class="space-y-5 rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="registration_start_at" value="Mulai Pendaftaran" />
                <x-text-input id="registration_start_at" name="registration_start_at" type="datetime-local" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('registration_start_at', optional($perlombaan->registration_start_at)->format('Y-m-d\TH:i'))" />
                <x-input-error :messages="$errors->get('registration_start_at')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="registration_end_at" value="Selesai Pendaftaran" />
                <x-text-input id="registration_end_at" name="registration_end_at" type="datetime-local" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('registration_end_at', optional($perlombaan->registration_end_at)->format('Y-m-d\TH:i'))" />
                <x-input-error :messages="$errors->get('registration_end_at')" class="mt-2" />
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="submission_deadline_at" value="Deadline Submission" />
                <x-text-input id="submission_deadline_at" name="submission_deadline_at" type="datetime-local" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('submission_deadline_at', optional($perlombaan->submission_deadline_at)->format('Y-m-d\TH:i'))" />
                <x-input-error :messages="$errors->get('submission_deadline_at')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="announcement_at" value="Tanggal Pengumuman" />
                <x-text-input id="announcement_at" name="announcement_at" type="datetime-local" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('announcement_at', optional($perlombaan->announcement_at)->format('Y-m-d\TH:i'))" />
                <x-input-error :messages="$errors->get('announcement_at')" class="mt-2" />
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="deadline_pendaftaran" value="Deadline Pendaftaran (Cadangan)" />
                <x-text-input id="deadline_pendaftaran" name="deadline_pendaftaran" type="date" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('deadline_pendaftaran', optional($perlombaan->deadline_pendaftaran)->format('Y-m-d'))" />
                <x-input-error :messages="$errors->get('deadline_pendaftaran')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="max_participants" value="Maksimal Peserta" />
                <x-text-input id="max_participants" name="max_participants" type="number" min="1" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('max_participants', $perlombaan->max_participants)" placeholder="opsional" />
                <x-input-error :messages="$errors->get('max_participants')" class="mt-2" />
            </div>
        </div>

        <div class="rounded-2xl bg-slate-50 p-5 text-sm leading-7 text-slate-600">
            <p class="font-bold text-slate-900">Catatan</p>
            <p class="mt-2">Setelah perlombaan dibuat, tahap berikutnya yang paling pas adalah menambahkan kriteria penilaian dan assignment juri untuk lomba ini.</p>
        </div>
    </div>
</div>

<div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <a href="{{ route('admin.perlombaan.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
        Kembali
    </a>

    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
        {{ $submitLabel }}
    </button>
</div>
