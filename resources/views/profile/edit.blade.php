<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 relative z-10">
            <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">person</span>
                <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">User Profile</span>
            </div>

            <h2 class="text-3xl font-black tracking-tight text-white uppercase sm:text-4xl">
                Profil <span class="text-amber-400 drop-shadow-[0_0_10px_rgba(251,191,36,0.5)]">{{ explode(' ', $user->name)[0] }}</span>
                @if($user->role === 'admin')
                    <span class="inline-flex items-center gap-1 ml-4 px-3 py-1 rounded-full bg-red-900/60 text-red-400 text-xs font-black uppercase tracking-widest border border-red-500/30 shadow-[0_0_10px_rgba(239,68,68,0.3)]">
                        <span class="material-symbols-outlined text-[12px]">admin_panel_settings</span>
                        Admin
                    </span>
                @elseif($user->role === 'juri')
                    <span class="inline-flex items-center gap-1 ml-4 px-3 py-1 rounded-full bg-blue-900/60 text-blue-400 text-xs font-black uppercase tracking-widest border border-blue-500/30 shadow-[0_0_10px_rgba(59,130,246,0.3)]">
                        <span class="material-symbols-outlined text-[12px]">gavel</span>
                        Juri
                    </span>
                @elseif($user->role === 'pendaftar')
                    <span class="inline-flex items-center gap-1 ml-4 px-3 py-1 rounded-full bg-green-900/60 text-green-400 text-xs font-black uppercase tracking-widest border border-green-500/30 shadow-[0_0_10px_rgba(34,197,94,0.3)]">
                        <span class="material-symbols-outlined text-[12px]">school</span>
                        Peserta
                    </span>
                @endif
            </h2>
            <p class="max-w-2xl text-base font-medium leading-relaxed text-white">
                Kelola informasi profil dan pengaturan akun Anda.
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden text-white" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-amber-500/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 md:px-6 lg:px-8 relative z-10">
            <div class="grid gap-6 lg:grid-cols-[1fr_0.8fr] transition-all duration-700 ease-out"
                 :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">

                <!-- Profile Information Card -->
                <div class="flex flex-col justify-center rounded-tl-3xl rounded-br-3xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-[0_0_20px_rgba(0,0,0,0.5)] hover:border-amber-500/30 hover:shadow-[0_0_40px_rgba(251,191,36,0.2)] hover:-translate-y-2 hover:rotate-1 transition-all duration-300 transform-gpu perspective-1000">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-amber-400/10 rounded-lg">
                            <span class="material-symbols-outlined text-amber-400">account_circle</span>
                        </div>
                        <h3 class="text-xl font-black uppercase tracking-wide text-white">Informasi Profil</h3>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Password Update Card -->
                <div class="flex flex-col justify-center rounded-tl-3xl rounded-br-3xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-[0_0_20px_rgba(0,0,0,0.5)] hover:border-red-500/30 hover:shadow-[0_0_40px_rgba(239,68,68,0.2)] hover:-translate-y-2 hover:-rotate-1 transition-all duration-300 transform-gpu perspective-1000">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-red-400/10 rounded-lg">
                            <span class="material-symbols-outlined text-red-400">lock</span>
                        </div>
                        <h3 class="text-xl font-black uppercase tracking-wide text-white">Ubah Kata Sandi</h3>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Account Deletion Card -->
                <div class="flex flex-col justify-center rounded-tl-3xl rounded-br-3xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-[0_0_20px_rgba(0,0,0,0.5)] hover:border-red-600/30 hover:shadow-[0_0_40px_rgba(220,38,38,0.2)] hover:-translate-y-2 hover:rotate-1 transition-all duration-300 transform-gpu perspective-1000">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-red-600/10 rounded-lg">
                            <span class="material-symbols-outlined text-red-600">delete_forever</span>
                        </div>
                        <h3 class="text-xl font-black uppercase tracking-wide text-white">Hapus Akun</h3>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
