<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <div class="space-y-5 rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('name', $user->name)" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full rounded-2xl border-slate-200" :value="old('email', $user->email)" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role" value="Role" />
            <select id="role" name="role" class="mt-2 block w-full rounded-2xl border-slate-200 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @selected(old('role', $user->role ?: \App\Models\User::ROLE_PENDAFTAR) === $role)>
                        {{ str($role)->replace('_', ' ')->title() }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
    </div>

    <div class="space-y-5 rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div>
            <x-input-label for="password" :value="$isEdit ? 'Password Baru (Opsional)' : 'Password'" />
            <x-text-input id="password" name="password" type="password" class="mt-2 block w-full rounded-2xl border-slate-200" :required="! $isEdit" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full rounded-2xl border-slate-200" :required="! $isEdit" />
        </div>

        <div class="rounded-2xl bg-slate-50 p-5 text-sm leading-7 text-slate-600">
            <p class="font-bold text-slate-900">Catatan Pengelolaan Akun</p>
            <p class="mt-2">Gunakan role <span class="font-semibold">juri</span> untuk akun penilai yang dibuat admin. Role <span class="font-semibold">pendaftar</span> tetap bisa mendaftar sendiri lewat form registrasi publik.</p>
            @if ($isEdit)
                <p class="mt-2">Kosongkan password jika tidak ingin menggantinya.</p>
            @endif
        </div>
    </div>
</div>

<div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
        Kembali
    </a>

    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
        {{ $submitLabel }}
    </button>
</div>
