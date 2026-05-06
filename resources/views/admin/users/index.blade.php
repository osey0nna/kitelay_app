<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 relative z-10">
            <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">admin_panel_settings</span>
                <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Admin Control Center</span>
            </div>
            
            <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl drop-shadow-md">
                Kelola <span class="text-amber-400">User</span>
            </h2>
            <p class="text-sm font-medium text-slate-400">Kelola akun admin, juri, dan pendaftar dengan struktur yang lebih rapi.</p>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-red-600/5 rounded-full blur-[120px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <div class="flex justify-end">
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 rounded-sm bg-gradient-to-r from-red-600 to-red-800 px-6 py-3 text-[11px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:scale-105 transition-all skew-x-[-10deg]">
                    <span class="skew-x-[10deg]">Tambah User</span>
                    <span class="material-symbols-outlined text-[16px] skew-x-[10deg]">person_add</span>
                </a>
            </div>

            <section class="overflow-hidden rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-800 text-sm">
                        <thead class="bg-[#0a0a0c] text-left text-[11px] font-black uppercase tracking-widest text-slate-500">
                            <tr>
                                <th class="px-6 py-5">User</th>
                                <th class="px-6 py-5">Role</th>
                                <th class="px-6 py-5">Dibuat</th>
                                <th class="px-6 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800 bg-[#050505]">
                            @forelse ($users as $user)
                                <tr class="tilt-row transition-colors hover:bg-[#0a0a0c]">
                                    <td class="px-6 py-6">
                                        <p class="text-[15px] font-black uppercase tracking-wide text-white">{{ $user->name }}</p>
                                        <p class="mt-1 text-[13px] text-slate-500 font-mono">{{ $user->email }}</p>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="inline-flex px-3 py-1.5 text-[10px] font-black uppercase tracking-widest bg-gradient-to-r from-red-900/60 to-black text-amber-400 border-l-2 border-amber-400 skew-x-[-10deg]">
                                            <span class="skew-x-[10deg]">{{ str($user->role)->replace('_', ' ')->title() }}</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-[13px] font-bold tracking-widest text-slate-400 uppercase">
                                        {{ $user->created_at?->translatedFormat('d M Y H:i') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-black px-5 py-2.5 text-[11px] font-black uppercase tracking-widest text-slate-300 transition-all hover:border-amber-400 hover:text-amber-400 skew-x-[-10deg]">
                                                <span class="skew-x-[10deg]">Edit</span>
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus akun ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-black px-5 py-2.5 text-[11px] font-black uppercase tracking-widest text-red-500 transition-all hover:border-red-500 skew-x-[-10deg]">
                                                    <span class="skew-x-[10deg]">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-[12px] font-black uppercase tracking-widest text-slate-600">
                                        Belum ada user yang tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiltRows = document.querySelectorAll('.tilt-row');

            tiltRows.forEach(row => {
                row.style.transition = 'transform 0.1s ease-out';
                row.style.transformStyle = 'preserve-3d';

                row.addEventListener('mousemove', (e) => {
                    const rect = row.getBoundingClientRect();
                    const y = e.clientY - rect.top;
                    const centerY = rect.height / 2;
                    const rotateX = ((y - centerY) / centerY) * -2; // Rotasi halus

                    row.style.transform = `perspective(1000px) rotateX(${rotateX}deg) scale(1.005)`;
                });

                row.addEventListener('mouseleave', () => {
                    row.style.transition = 'transform 0.5s ease-out';
                    row.style.transform = `perspective(1000px) rotateX(0deg) scale(1)`;
                });
            });
        });
    </script>
</x-app-layout>