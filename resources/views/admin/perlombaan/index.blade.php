<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between relative z-10">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                    <span class="material-symbols-outlined text-[16px] text-amber-400">admin_panel_settings</span>
                    <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Admin Panel</span>
                </div>
                
                <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl drop-shadow-md">
                    Kelola <span class="text-amber-400">Perlombaan</span>
                </h2>
                <p class="max-w-2xl text-sm font-medium leading-7 text-slate-400">Pantau struktur lomba, assignment juri, dan titik masuk ke hasil akhir dari satu meja kerja admin.</p>
            </div>

            <a href="{{ route('admin.perlombaan.create') }}" class="inline-flex items-center justify-center gap-2 rounded-sm bg-gradient-to-r from-red-600 to-red-800 px-6 py-3 text-[11px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:scale-105 transition-all skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Tambah Perlombaan</span>
                <span class="material-symbols-outlined text-[16px] skew-x-[10deg]">add_circle</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <section class="tilt-card rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-orange-400 to-red-600"></div>
                
                <div class="max-w-3xl">
                    <p class="text-[11px] font-black uppercase tracking-widest text-orange-500">Ringkasan</p>
                    <h3 class="mt-2 text-2xl font-black uppercase tracking-wide text-white">Data lomba yang sudah masuk ke sistem.</h3>
                    <p class="mt-3 text-[14px] leading-relaxed text-slate-400">Halaman ini ditata supaya admin bisa langsung membaca status, volume peserta, dan jalur aksi tiap lomba tanpa perlu pindah-pindah halaman dulu.</p>
                </div>

                <div class="mt-6 inline-flex flex-col items-center justify-center rounded-xl border border-neutral-800 bg-[#050505] px-8 py-5 shadow-inner">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Lomba</p>
                    <p class="mt-2 text-4xl font-black text-white">{{ method_exists($perlombaans, 'total') ? $perlombaans->total() : $perlombaans->count() }}</p>
                </div>
            </section>

            <section class="overflow-hidden rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] shadow-2xl relative">
                
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-600 via-amber-500 to-red-900"></div>

                <div class="px-6 py-5 border-b border-neutral-800 bg-[#050505] flex items-center gap-3">
                    <span class="material-symbols-outlined text-amber-500">format_list_bulleted</span>
                    <h3 class="text-[12px] font-black uppercase tracking-widest text-white">Daftar Induk Perlombaan</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-800 text-sm">
                        <thead class="bg-[#0a0a0c] text-left text-[10px] font-black uppercase tracking-widest text-amber-500 border-b border-neutral-700 shadow-sm">
                            <tr>
                                <th class="px-6 py-5">Perlombaan</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5 text-center">Peserta</th>
                                <th class="px-6 py-5 text-center">Kriteria</th>
                                <th class="px-6 py-5 text-center">Juri</th>
                                <th class="px-6 py-5">Deadline</th>
                                <th class="px-6 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800 bg-[#0a0a0c]">
                            @forelse ($perlombaans as $perlombaan)
                                <tr class="tilt-row transition-colors hover:bg-[#050505]">
                                    <td class="px-6 py-6 align-top">
                                        <div class="max-w-[250px]">
                                            <p class="text-[15px] font-black uppercase tracking-wide text-white leading-tight">{{ $perlombaan->nama_lomba }}</p>
                                            <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $perlombaan->slug }}</p>
                                            <p class="mt-3 text-[12px] font-medium leading-relaxed text-slate-400 line-clamp-3">{{ $perlombaan->deskripsi }}</p>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-6 align-top">
                                        <span class="inline-flex px-3 py-1.5 text-[9px] font-black uppercase tracking-widest bg-gradient-to-r from-sky-900/40 to-black text-sky-400 border-l-2 border-sky-400 skew-x-[-10deg]">
                                            <span class="skew-x-[10deg]">{{ str($perlombaan->status)->replace('_', ' ')->title() }}</span>
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-6 align-top text-center text-lg font-black text-white">{{ $perlombaan->pendaftarans_count }}</td>
                                    <td class="px-6 py-6 align-top text-center text-lg font-black text-white">{{ $perlombaan->kriterias_count }}</td>
                                    <td class="px-6 py-6 align-top text-center text-lg font-black text-white">{{ $perlombaan->juris_count }}</td>
                                    
                                    <td class="px-6 py-6 align-top">
                                        <p class="text-[13px] font-bold text-slate-300">
                                            {{ optional($perlombaan->registration_end_at)->translatedFormat('d M Y') ?? optional($perlombaan->deadline_pendaftaran)->translatedFormat('d M Y') ?? '-' }}
                                        </p>
                                    </td>
                                    
                                    <td class="px-6 py-6 align-top">
                                        <div class="flex flex-wrap justify-end gap-2 max-w-[280px]">
                                            <a href="{{ route('admin.perlombaan.kriteria.index', $perlombaan) }}" class="inline-flex items-center justify-center rounded-sm border border-sky-500/30 bg-sky-900/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-sky-400 hover:bg-sky-900/40 transition-colors skew-x-[-10deg]">
                                                <span class="skew-x-[10deg]">Kriteria</span>
                                            </a>
                                            <a href="{{ route('admin.perlombaan.juri.index', $perlombaan) }}" class="inline-flex items-center justify-center rounded-sm border border-emerald-500/30 bg-emerald-900/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-emerald-400 hover:bg-emerald-900/40 transition-colors skew-x-[-10deg]">
                                                <span class="skew-x-[10deg]">Juri</span>
                                            </a>
                                            <a href="{{ route('admin.perlombaan.edit', $perlombaan) }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-600 bg-neutral-900/30 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-400 transition-colors skew-x-[-10deg]">
                                                <span class="skew-x-[10deg]">Edit</span>
                                            </a>
                                            <form method="POST" action="{{ route('admin.perlombaan.destroy', $perlombaan) }}" onsubmit="return confirm('Hapus perlombaan ini?')" class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-sm border border-red-500/50 bg-red-900/20 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-600 hover:text-white transition-colors skew-x-[-10deg]">
                                                    <span class="skew-x-[10deg]">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <span class="material-symbols-outlined text-4xl text-slate-700 mb-3 block">inbox</span>
                                        <p class="text-[12px] font-black uppercase tracking-widest text-slate-500">Belum ada perlombaan. Tambahkan data pertama.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            @if(method_exists($perlombaans, 'links'))
                <div class="mt-4 flex justify-center [&>nav]:w-full [&>nav]:flex [&>nav]:justify-center [color-scheme:dark]">
                    {{ $perlombaans->links() }}
                </div>
            @endif

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
                    el.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(251, 191, 36, 0.15), 0 0 15px rgba(220, 38, 38, 0.2)`;
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
