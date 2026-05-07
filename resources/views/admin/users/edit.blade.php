<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 relative z-10">
            <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">admin_panel_settings</span>
                <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Admin Panel</span>
            </div>

            <h2 class="text-2xl md:text-3xl lg:text-4xl font-black uppercase tracking-tight text-white">
                Edit User
            </h2>
            <p class="max-w-2xl text-sm md:text-base font-medium leading-relaxed text-white">
                Mengedit informasi pengguna: <span class="text-amber-400">{{ $user->name }}</span> - {{ $user->email }}
            </p>
        </div>
    </x-slot>

    <div class="py-6 md:py-10 bg-black min-h-screen relative overflow-hidden text-white" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-amber-500/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8 relative z-10">
            <div class="transition-all duration-700 ease-out"
                 :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="rounded-tl-3xl rounded-br-3xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-6 md:p-8 shadow-[0_0_20px_rgba(0,0,0,0.5)] hover:border-amber-500/30 hover:shadow-[0_0_40px_rgba(251,191,36,0.2)] hover:-translate-y-2 transition-all duration-300 transform-gpu perspective-1000">
                    @csrf
                    @method('PUT')

                    @include('admin.users._form', [
                        'submitLabel' => 'Update User',
                        'isEdit' => true,
                    ])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
