<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <div class="space-y-5 rounded-tl-3xl rounded-br-3xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-6 shadow-[0_0_20px_rgba(0,0,0,0.5)]">
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-2xl border-neutral-600 bg-[#0a0a0c] text-white placeholder-gray-400" :value="old('name', $user->name)" required autofocus placeholder="Masukkan nama lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full rounded-2xl border-neutral-600 bg-[#0a0a0c] text-white placeholder-gray-400" :value="old('email', $user->email)" required placeholder="Masukkan alamat email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role" value="Role" />
            <select id="role" name="role" class="mt-2 block w-full rounded-2xl border-neutral-600 bg-[#0a0a0c] text-white shadow-sm focus:border-amber-400 focus:ring-amber-400" required>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @selected(old('role', $user->role ?: \App\Models\User::ROLE_PENDAFTAR) === $role)>
                        {{ str($role)->replace('_', ' ')->title() }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
    </div>

    <div class="space-y-5 rounded-tl-3xl rounded-br-3xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-6 shadow-[0_0_20px_rgba(0,0,0,0.5)]">
        <div>
            <x-input-label for="password" :value="$isEdit ? 'Password Baru (Opsional)' : 'Password'" />
            <x-text-input id="password" name="password" type="password" class="mt-2 block w-full rounded-2xl border-neutral-600 bg-[#0a0a0c] text-white placeholder-gray-400" :required="! $isEdit" :placeholder="$isEdit ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password'" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full rounded-2xl border-neutral-600 bg-[#0a0a0c] text-white placeholder-gray-400" :required="! $isEdit" placeholder="Konfirmasi password" />
        </div>

        <div class="rounded-2xl bg-neutral-900 p-5 text-sm leading-7 text-gray-300 border border-neutral-700">
            <p class="font-bold text-white">Catatan Pengelolaan Akun</p>
            <p class="mt-2">Gunakan role <span class="font-semibold text-amber-400">juri</span> untuk akun penilai yang dibuat admin. Role <span class="font-semibold text-green-400">pendaftar</span> tetap bisa mendaftar sendiri lewat form registrasi publik.</p>
            @if ($isEdit)
                <p class="mt-2">Kosongkan password jika tidak ingin menggantinya.</p>
            @endif
        </div>
    </div>
</div>

<div class="mt-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
        Kembali
    </a>

    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
        {{ $submitLabel }}
    </button>
</div>
