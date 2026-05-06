<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between relative z-10">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-sky-400 bg-gradient-to-r from-sky-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(56,189,248,0.1)]">
                    <span class="material-symbols-outlined text-[16px] text-sky-400">rule</span>
                    <span class="text-[11px] font-black uppercase tracking-widest text-sky-400">Admin Panel</span>
                </div>
                
                <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl drop-shadow-md">
                    Kriteria <span class="text-sky-400">Penilaian</span>
                </h2>
                <p class="max-w-2xl text-sm font-medium leading-7 text-slate-400">Lomba: <span class="text-white">{{ $perlombaan->nama_lomba }}</span></p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.perlombaan.index') }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-transparent px-5 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-500 hover:text-white transition-all skew-x-[-10deg]">
                    <span class="skew-x-[10deg]">Kembali</span>
                </a>
                
                <a href="{{ route('admin.perlombaan.kriteria.create', $perlombaan) }}" class="inline-flex items-center justify-center gap-2 rounded-sm bg-gradient-to-r from-sky-600 to-indigo-800 px-6 py-3 text-[11px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(56,189,248,0.3)] hover:scale-105 transition-all skew-x-[-10deg]">
                    <span class="skew-x-[10deg]">Tambah Kriteria</span>
                    <span class="material-symbols-outlined text-[16px] skew-x-[10deg]">add_circle</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-sky-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <section class="grid gap-6 md:grid-cols-3">
                <div class="tilt-card rounded-xl border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl hover:border-sky-500/30 transition-all">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Kriteria</p>
                    <p class="mt-2 text-4xl font-black text-white">{{ $kriterias->count() }}</p>
                </div>
                
                <div class="tilt-card rounded-xl border {{ $totalBobot === 100 ? 'border-emerald-900/50 bg-emerald-900/10' : 'border-amber-900/50 bg-amber-900/10' }} p-6 shadow-xl transition-all">
                    <p class="text-[10px] font-black uppercase tracking-widest {{ $totalBobot === 100 ? 'text-emerald-500' : 'text-amber-500' }}">Total Bobot (Maks 100)</p>
                    <p class="mt-2 text-4xl font-black {{ $totalBobot === 100 ? 'text-emerald-400 drop-shadow-[0_0_8px_rgba(52,211,153,0.5)]' : 'text-amber-400 drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' }}">
                        {{ $totalBobot }}<span class="text-xl text-slate-500">%</span>
                    </p>
                </div>
                
                <div class="tilt-card rounded-xl border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl hover:border-neutral-700 transition-all">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Status Validasi</p>
                    <div class="mt-3 flex items-center gap-3">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $totalBobot === 100 ? 'bg-emerald-400' : 'bg-amber-400' }} opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 {{ $totalBobot === 100 ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                        </span>
                        <p class="text-[13px] font-black uppercase tracking-widest {{ $totalBobot === 100 ? 'text-emerald-400' : 'text-amber-400' }}">
                            {{ $totalBobot === 100 ? 'Bobot Ideal (Siap)' : 'Cek Kembali Bobot' }}
                        </p>
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] shadow-2xl relative">
                
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-sky-400 via-indigo-500 to-sky-900"></div>

                <div class="px-6 py-5 border-b border-neutral-800 bg-[#050505] flex items-center gap-3">
                    <span class="material-symbols-outlined text-sky-500">checklist</span>
                    <h3 class="text-[12px] font-black uppercase tracking-widest text-white">Struktur Penilaian</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-800 text-sm">
                        <thead class="bg-[#0a0a0c] text-left text-[10px] font-black uppercase tracking-widest text-sky-500 border-b border-neutral-700 shadow-sm">
                            <tr>
                                <th class="px-6 py-5 text-center w-24">Urutan</th>
                                <th class="px-6 py-5">Kriteria</th>
                                <th class="px-6 py-5 text-center">Bobot</th>
                                <th class="px-6 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800 bg-[#0a0a0c]">
                            @forelse ($kriterias as $kriteria)
                                <tr class="tilt-row transition-colors hover:bg-[#050505]">
                                    <td class="px-6 py-6 align-middle text-center text-xl font-black text-slate-500">
                                        #{{ $kriteria->urutan }}
                                    </td>
                                    
                                    <td class="px-6 py-6 align-top">
                                        <p class="text-lg font-black uppercase tracking-wide text-white">{{ $kriteria->nama_kriteria }}</p>
                                        <p class="mt-2 max-w-2xl text-[12px] font-medium leading-relaxed text-slate-400">{{ $kriteria->deskripsi ?: 'Belum ada deskripsi spesifik untuk juri.' }}</p>
                                    </td>
                                    
                                    <td class="px-6 py-6 align-middle text-center">
                                        <span class="inline-flex px-3 py-1.5 text-[12px] font-black uppercase tracking-widest bg-sky-900/20 text-sky-400 border border-sky-500/30 skew-x-[-10deg]">
                                            <span class="skew-x-[10deg]">{{ $kriteria->bobot }}%</span>
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-6 align-middle">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.perlombaan.kriteria.edit', [$perlombaan, $kriteria]) }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-600 bg-neutral-900/30 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-400 transition-colors skew-x-[-10deg]">
                                                <span class="skew-x-[10deg]">Edit</span>
                                            </a>
                                            <form method="POST" action="{{ route('admin.perlombaan.kriteria.destroy', [$perlombaan, $kriteria]) }}" onsubmit="return confirm('Hapus kriteria ini secara permanen?')" class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-sm border border-red-500/50 bg-red-900/20 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-600 hover:text-white transition-colors skew-x-[-10deg]">
                                                    <span class="skew-x-[10deg]">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <span class="material-symbols-outlined text-4xl text-slate-700 mb-3 block">format_list_bulleted</span>
                                        <p class="text-[12px] font-black uppercase tracking-widest text-slate-500">Belum ada kriteria penilaian. Tambahkan agar juri bisa bekerja.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiltElements = document.querySelectorAll('.tilt-card, .tilt-row');
            
            tiltElements.forEach(el => {
                el.style.transformStyle = 'preserve-3d';
                
                el.addEventListener('mouseenter', () => {
                    el.style.transition = 'transform 0.1s ease-out, box-shadow 0.1s ease-out';
                    el.style.zIndex = "50"; 
                });

                el.addEventListener('mousemove', (e) => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = ((y - centerY) / centerY) * -12; 
                    const rotateY = ((x - centerX) / centerX) * 12;
                    const scale = el.classList.contains('tilt-row') ? 1.02 : 1.05;
                    
                    el.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(${scale})`;

                    const shadowX = ((x - centerX) / centerX) * -20;
                    const shadowY = ((y - centerY) / centerY) * -20;
                    // Glow Biru/Sky untuk menyesuaikan tema kriteria
                    el.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(56, 189, 248, 0.15), 0 0 15px rgba(56, 189, 248, 0.2)`;
                });

                el.addEventListener('mouseleave', () => {
                    el.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.6s ease-out';
                    el.style.transform = `perspective(800px) rotateX(0deg) rotateY(0deg) scale(1)`;
                    el.style.boxShadow = '';
                    el.style.zIndex = "1";
                });
            });
        });
    </script>
</x-app-layout>