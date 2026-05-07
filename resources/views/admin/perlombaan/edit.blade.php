<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 relative z-10">
            <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">edit_square</span>
                <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Admin Control Center</span>
            </div>
            
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-black uppercase tracking-tight text-white drop-shadow-md">
                Edit <span class="text-amber-400">Perlombaan</span>
            </h2>
            <p class="text-xs md:text-sm font-medium text-slate-400">Rapikan detail lomba yang sudah berjalan tanpa kehilangan struktur data utamanya.</p>
        </div>
    </x-slot>

    <div class="py-6 md:py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-amber-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto max-w-4xl px-4 md:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <form method="POST" action="{{ route('admin.perlombaan.update', $perlombaan) }}" 
                  class="tilt-card rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl transition-all hover:border-neutral-700 relative overflow-hidden group">
                
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-amber-500 to-red-600"></div>
                
                @csrf
                @method('PUT')

                <div class="relative z-10">
                    @include('admin.perlombaan._form', [
                        'submitLabel' => 'Update Perlombaan',
                    ])
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiltCards = document.querySelectorAll('.tilt-card');
            
            tiltCards.forEach(card => {
                card.style.transition = 'transform 0.1s ease-out';
                card.style.transformStyle = 'preserve-3d';
                
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    // Rotasi sangat halus untuk form (agar tidak pusing saat mengetik)
                    const rotateX = ((y - centerY) / centerY) * -1.5; 
                    const rotateY = ((x - centerX) / centerX) * 1.5;

                    card.style.transform = `perspective(1500px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.005)`;
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transition = 'transform 0.5s ease-out';
                    card.style.transform = `perspective(1500px) rotateX(0deg) rotateY(0deg) scale(1)`;
                });
            });
        });
    </script>
</x-app-layout>