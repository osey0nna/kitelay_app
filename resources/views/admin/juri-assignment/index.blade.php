<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between relative z-10">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-emerald-400 bg-gradient-to-r from-emerald-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(52,211,153,0.1)]">
                    <span class="material-symbols-outlined text-[16px] text-emerald-400">how_to_reg</span>
                    <span class="text-[11px] font-black uppercase tracking-widest text-emerald-400">Admin Panel</span>
                </div>
                
                <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl drop-shadow-md">
                    Assignment <span class="text-emerald-400">Juri</span>
                </h2>
                <p class="max-w-2xl text-sm font-medium leading-7 text-slate-400">Lomba: <span class="text-white">{{ $perlombaan->nama_lomba }}</span></p>
            </div>

            <a href="{{ route('admin.perlombaan.index') }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-transparent px-6 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-500 hover:text-white transition-all skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Kembali ke Perlombaan</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <section class="grid gap-6 md:grid-cols-3">
                <div class="tilt-card rounded-xl border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl hover:border-emerald-500/30 transition-all">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Juri Terdaftar</p>
                    <p class="mt-2 text-4xl font-black text-white">{{ $availableJuries->count() }}</p>
                </div>
                
                <div class="tilt-card rounded-xl border {{ count($assignedIds) > 0 ? 'border-emerald-900/50 bg-emerald-900/10' : 'border-amber-900/50 bg-amber-900/10' }} p-6 shadow-xl transition-all">
                    <p class="text-[10px] font-black uppercase tracking-widest {{ count($assignedIds) > 0 ? 'text-emerald-500' : 'text-amber-500' }}">Juri Ditugaskan</p>
                    <p class="mt-2 text-4xl font-black {{ count($assignedIds) > 0 ? 'text-emerald-400 drop-shadow-[0_0_8px_rgba(52,211,153,0.5)]' : 'text-amber-400 drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' }}">
                        {{ count($assignedIds) }}
                    </p>
                </div>
                
                <div class="tilt-card rounded-xl border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl hover:border-neutral-700 transition-all">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Status Kesiapan</p>
                    <div class="mt-3 flex items-center gap-3">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ count($assignedIds) > 0 ? 'bg-emerald-400' : 'bg-amber-400' }} opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 {{ count($assignedIds) > 0 ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                        </span>
                        <p class="text-[13px] font-black uppercase tracking-widest {{ count($assignedIds) > 0 ? 'text-emerald-400' : 'text-amber-400' }}">
                            {{ count($assignedIds) > 0 ? 'Siap Penilaian' : 'Menunggu Juri' }}
                        </p>
                    </div>
                </div>
            </section>

            <form method="POST" action="{{ route('admin.perlombaan.juri.update', $perlombaan) }}" class="rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-emerald-400 to-emerald-700"></div>
                
                @csrf
                @method('PUT')

                <div class="border-b border-neutral-800 pb-6">
                    <p class="text-[11px] font-black uppercase tracking-widest text-emerald-500">Daftar Kandidat</p>
                    <h3 class="mt-2 text-2xl font-black uppercase tracking-wide text-white">Pilih Juri Untuk Perlombaan Ini</h3>
                    <p class="mt-2 text-[14px] leading-relaxed text-slate-400">Centang kotak juri di bawah ini untuk memberikan akses penilaian kepada mereka.</p>
                </div>

                <x-input-error :messages="$errors->get('juri_ids')" class="mt-4" />
                <x-input-error :messages="$errors->get('juri_ids.*')" class="mt-2" />

                <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3 relative z-10">
                    @forelse ($availableJuries as $juri)
                        @php
                            $isAssigned = in_array($juri->id, old('juri_ids', $assignedIds), true);
                        @endphp
                        <label class="tilt-card flex cursor-pointer items-start gap-4 rounded-xl border {{ $isAssigned ? 'border-emerald-500/50 bg-emerald-900/10' : 'border-neutral-800 bg-[#050505]' }} p-6 transition-all hover:border-emerald-500 group relative overflow-hidden">
                            
                            @if($isAssigned) <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/20 blur-[20px] rounded-full pointer-events-none"></div> @endif

                            <div class="relative flex items-center justify-center mt-1">
                                <input type="checkbox" name="juri_ids[]" value="{{ $juri->id }}" @checked($isAssigned) 
                                       class="peer relative h-6 w-6 shrink-0 appearance-none rounded-sm border border-neutral-600 bg-black checked:border-emerald-500 checked:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-colors cursor-pointer">
                                <svg class="absolute w-4 h-4 text-black pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>

                            <div class="relative z-10">
                                <p class="text-xl font-black uppercase tracking-wide {{ $isAssigned ? 'text-emerald-400' : 'text-white' }} group-hover:text-emerald-400 transition-colors">{{ $juri->name }}</p>
                                <p class="mt-1 text-[12px] font-medium leading-relaxed text-slate-500">{{ $juri->email }}</p>
                                
                                <div class="mt-4 inline-flex px-2 py-1 text-[9px] font-black uppercase tracking-widest bg-neutral-900 text-slate-400 border border-neutral-700 skew-x-[-10deg]">
                                    <span class="skew-x-[10deg]">Tugas Aktif: {{ $juri->lomba_dinilai_count }} Lomba</span>
                                </div>
                            </div>
                        </label>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-neutral-800 bg-[#050505] p-12 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-700 mb-3 block">group_off</span>
                            <p class="text-[12px] font-black uppercase tracking-widest text-slate-500">Belum ada akun pengguna dengan role Juri. Silakan tambahkan juri terlebih dahulu di Kelola User.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-neutral-800 pt-8 relative z-10">
                    <p class="text-[11px] leading-relaxed text-slate-500 max-w-md">Perubahan ini langsung berlaku. Juri yang dihapus dari daftar tidak akan bisa mengakses halaman penilaian lomba ini lagi.</p>
                    
                    <button type="submit" class="inline-flex items-center justify-center rounded-sm bg-gradient-to-r from-emerald-600 to-emerald-800 px-8 py-4 text-[12px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(52,211,153,0.4)] hover:scale-105 hover:border-emerald-400 border border-transparent transition-all skew-x-[-10deg]">
                        <span class="skew-x-[10deg]">Simpan Assignment</span>
                    </button>
                </div>
            </form>
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
                    // Glow Hijau/Emerald untuk menyesuaikan tema Assignment
                    el.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(52, 211, 153, 0.15), 0 0 15px rgba(52, 211, 153, 0.2)`;
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