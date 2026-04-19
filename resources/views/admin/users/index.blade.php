<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-600">Admin Panel</p>
                <h2 class="text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">Kelola User</h2>
                <p class="max-w-2xl text-sm leading-7 text-slate-500 sm:text-base">Kelola akun admin, juri, dan pendaftar dengan struktur yang lebih rapi dan mudah dipindai.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                Tambah User
                <span class="material-symbols-outlined text-base">person_add</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">
            <x-page-hero eyebrow="Akses" title="Kelola akun admin, juri, dan pendaftar dari satu tempat." description="Tiap akun punya peran berbeda di sistem lomba, jadi tabel ini saya buat lebih nyaman untuk scanning cepat saat admin mengecek struktur user." accent="sky" />

            <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-[11px] font-black uppercase tracking-[0.22em] text-slate-500">
                            <tr>
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Dibuat</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white text-slate-700">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-5 align-top">
                                        <p class="text-lg font-black tracking-[-0.03em] text-slate-950">{{ $user->name }}</p>
                                        <p class="mt-1 text-sm leading-7 text-slate-500">{{ $user->email }}</p>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <span class="inline-flex rounded-full bg-sky-50 px-3 py-1 text-[10px] font-black uppercase tracking-[0.16em] text-sky-700">
                                            {{ str($user->role)->replace('_', ' ')->title() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 align-top text-sm leading-7 text-slate-500">{{ $user->created_at?->translatedFormat('d M Y H:i') ?? '-' }}</td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus akun ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-red-200 px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-red-600 transition hover:bg-red-50">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">
                                        Belum ada user yang tercatat di sistem.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
