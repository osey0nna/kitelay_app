<x-guest-layout>
    <x-auth-session-status
        class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-300"
        :status="session('status')"
    />

    <div class="mb-8 space-y-4 text-center">
        <div class="inline-flex items-center gap-2 rounded-full border border-amber-400/20 bg-gradient-to-r from-red-900/40 to-black px-4 py-2 text-[10px] font-black uppercase tracking-[0.35em] text-amber-300">
            <span class="h-2 w-2 rounded-full bg-amber-400 shadow-[0_0_10px_rgba(251,191,36,0.9)]"></span>
            Dashboard Access
        </div>

        <div class="space-y-3">
            <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-[2rem]">
                Login <span class="bg-gradient-to-r from-red-500 via-red-600 to-amber-400 bg-clip-text text-transparent">Dashboard</span>
            </h2>
            <p class="mx-auto max-w-xs text-sm font-medium leading-6 text-slate-400">
                Masuk ke panel Kitelay untuk mengelola perlombaan, peserta, dan penilaian dengan lebih fokus.
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="relative z-10 space-y-4">
        @csrf

        <div class="space-y-2">
            <label for="email" class="block text-[11px] font-black uppercase tracking-[0.32em] text-slate-400">Email Address</label>
            <div class="group relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 transition-colors duration-300 group-focus-within:text-amber-400">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    autocapitalize="none"
                    autocorrect="off"
                    spellcheck="false"
                    class="block w-full rounded-2xl border border-neutral-800 bg-black/70 px-4 py-3.5 pl-11 text-white placeholder:text-slate-600 outline-none transition-all duration-300 hover:border-red-700/60 focus:border-amber-400 focus:bg-black focus:ring-4 focus:ring-amber-400/10"
                    placeholder="email@sekolah.com"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="text-xs font-bold text-red-400" />
        </div>

        <div class="space-y-2">
            <div class="flex items-center justify-between gap-3">
                <label for="password" class="block text-[11px] font-black uppercase tracking-[0.32em] text-slate-400">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-400 transition-colors hover:text-amber-300" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <div class="group relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 transition-colors duration-300 group-focus-within:text-amber-400">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="block w-full rounded-2xl border border-neutral-800 bg-black/70 px-4 py-3.5 pl-11 text-white placeholder:text-slate-600 outline-none transition-all duration-300 hover:border-red-700/60 focus:border-amber-400 focus:bg-black focus:ring-4 focus:ring-amber-400/10"
                    placeholder="Masukkan password"
                >
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-xs font-bold text-red-400" />
        </div>

        <div class="flex items-center justify-between gap-4 pt-1">
            <label for="remember_me" class="group inline-flex cursor-pointer items-center gap-3">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-neutral-700 bg-black/70 text-amber-500 shadow-sm focus:ring-amber-400/40"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                >
                <span class="text-sm font-medium text-slate-400 transition-colors group-hover:text-slate-200">Ingat Saya</span>
            </label>
            <span class="hidden text-[10px] font-black uppercase tracking-[0.24em] text-slate-600 sm:inline">Akses Terenkripsi</span>
        </div>

        <div class="pt-3">
            <button type="submit" class="group relative z-10 inline-flex w-full touch-manipulation items-center justify-center overflow-hidden rounded-2xl border border-red-500/30 bg-gradient-to-r from-red-600 to-red-800 px-6 py-4 text-[12px] font-black uppercase tracking-[0.28em] text-white shadow-[0_0_24px_rgba(220,38,38,0.22)] transition-all duration-300 hover:-translate-y-0.5 hover:border-amber-400 hover:shadow-[0_0_28px_rgba(251,191,36,0.28)]">
                <span class="pointer-events-none absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/15 to-transparent transition-transform duration-700 group-hover:translate-x-full"></span>
                <span class="relative flex items-center gap-3">
                    Masuk Sekarang
                    <i class="fa-solid fa-arrow-right text-sm transition-transform duration-300 group-hover:translate-x-0.5"></i>
                </span>
            </button>
        </div>

        <div class="rounded-2xl border border-white/5 bg-white/[0.03] px-4 py-4 text-center">
            <p class="text-sm font-medium text-slate-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="ml-1 font-black text-white transition-colors hover:text-amber-400">Daftar di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
