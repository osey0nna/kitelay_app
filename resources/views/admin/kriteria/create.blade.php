<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between relative z-10">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-sky-400 bg-gradient-to-r from-sky-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(56,189,248,0.1)]">
                    <span class="material-symbols-outlined text-[16px] text-sky-400">add_box</span>
                    <span class="text-[11px] font-black uppercase tracking-widest text-sky-400">Admin Panel</span>
                </div>
                
                <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl">
                    Tambah <span class="text-sky-400">Kriteria</span>
                </h2>
                <p class="text-sm font-medium text-slate-400">Lomba: <span class="text-white">{{ $perlombaan->nama_lomba }}</span></p>
            </div>

            <a href="{{ route('admin.perlombaan.kriteria.index', $perlombaan) }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-transparent px-6 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-500 hover:text-white transition-all skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Kembali</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-sky-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <form method="POST" action="{{ route('admin.perlombaan.kriteria.store', $perlombaan) }}" class="tilt-card rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl relative overflow-hidden">
                
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-sky-400 via-indigo-500 to-sky-900"></div>
                
                @csrf

                <div class="mb-8 border-b border-neutral-800 pb-6">
                    <h3 class="text-xl font-black uppercase tracking-wide text-white">Informasi Kriteria</h3>
                    <p class="mt-2 text-[13px] text-slate-400">Masukkan detail kriteria penilaian yang akan digunakan oleh juri.</p>
                </div>

                @include('admin.kriteria._form', [
                    'submitLabel' => 'Simpan Kriteria',
                ])
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiltCard = document.querySelector('.tilt-card');
            tiltCard.style.transformStyle = 'preserve-3d';
            
            tiltCard.addEventListener('mousemove', (e) => {
                const rect = tiltCard.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = ((y - centerY) / centerY) * -5; 
                const rotateY = ((x - centerX) / centerX) * 5;
                
                tiltCard.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.01)`;
                tiltCard.style.boxShadow = '0 20px 40px rgba(56, 189, 248, 0.15)';
            });
            tiltCard.addEventListener('mouseleave', () => {
                tiltCard.style.transition = 'transform 0.5s ease-out, box-shadow 0.5s ease-out';
                tiltCard.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                tiltCard.style.boxShadow = '';
            });
        });
    </script>
</x-app-layout>