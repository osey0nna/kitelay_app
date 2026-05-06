<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 relative z-10">
            <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">info</span>
                <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Persiapan Peserta</span>
            </div>
            <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl drop-shadow-md">
                Detail <span class="text-amber-400">Lomba</span>
            </h2>
            <p class="text-sm font-medium text-slate-400">{{ $perlombaan->nama_lomba }}</p>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-amber-500/5 rounded-full blur-[100px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10">
            
            <section class="tilt-card rounded-tl-[3rem] rounded-br-[3rem] rounded-tr-md rounded-bl-md border border-red-900/50 bg-[#0a0a0c] p-8 shadow-xl relative overflow-hidden transition-all duration-700 ease-out"
                     :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                <div class="absolute top-0 left-0 w-2 h-full bg-red-600"></div>
                <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <h1 class="text-3xl font-black uppercase tracking-wide text-white sm:text-4xl leading-tight">{{ $perlombaan->nama_lomba }}</h1>
                        <p class="mt-4 text-[14px] font-medium leading-relaxed text-slate-400 max-w-2xl">
                            Baca detail lomba dan rundown lengkap di halaman ini terlebih dahulu. Setelah itu baru lanjutkan pendaftaran agar alurnya lebih jelas dan terstruktur.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="rounded-xl border border-neutral-800 bg-black p-4 text-center">
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Status</p>
                            <p class="mt-2 text-md font-black text-white">{{ str($perlombaan->status)->replace('_', ' ')->title() }}</p>
                        </div>
                        <div class="rounded-xl border border-neutral-800 bg-black p-4 text-center">
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Kriteria</p>
                            <p class="mt-2 text-xl font-black text-amber-400">{{ $perlombaan->kriterias_count }}</p>
                        </div>
                        <div class="rounded-xl border border-neutral-800 bg-black p-4 text-center">
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Sisa Kuota</p>
                            <p class="mt-2 text-xl font-black text-red-500">{{ $participantsRemaining ?? '∞' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr] transition-all duration-700 delay-150 ease-out"
                     :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                
                <article class="tilt-card rounded-tl-2xl rounded-br-2xl border border-neutral-800 bg-[#0a0a0c] p-8 shadow-lg hover:border-neutral-700 transition-colors">
                    <p class="text-[11px] font-black uppercase tracking-widest text-amber-500 border-b border-red-900/30 pb-3 w-fit">Tentang Lomba</p>
                    <h3 class="mt-4 text-2xl font-black uppercase tracking-wide text-white">Detail Informasi.</h3>
                    <p class="mt-5 text-[14px] leading-8 text-slate-400">{{ $perlombaan->deskripsi }}</p>
                </article>

                <article class="tilt-card rounded-tl-2xl rounded-br-2xl border border-neutral-800 bg-[#0a0a0c] p-8 shadow-lg relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-red-600/10 rounded-full blur-[30px]"></div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-red-500 border-b border-red-900/30 pb-3 w-fit relative z-10">Aksi Peserta</p>
                    <h3 class="mt-4 text-2xl font-black uppercase tracking-wide text-white relative z-10">Siap Bertanding?</h3>
                    <div class="mt-6 space-y-4 relative z-10">
                        @if ($existingRegistration)
                            <div class="rounded-xl border border-emerald-900/50 bg-emerald-900/10 p-5">
                                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-500">Status Pendaftaran</p>
                                <p class="mt-2 text-lg font-black text-white">Kamu sudah terdaftar.</p>
                            </div>
                            <a href="{{ route('peserta.lomba.edit', $existingRegistration) }}" class="inline-flex w-full items-center justify-center rounded-sm bg-gradient-to-r from-red-600 to-red-800 px-5 py-3.5 text-[12px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:scale-105 border border-transparent hover:border-amber-400 skew-x-[-10deg] transition-all">
                                <span class="skew-x-[10deg]">{{ $existingRegistration->submitted_at ? 'Edit Submission' : 'Isi Submission' }}</span>
                            </a>
                        @else
                            <form method="POST" action="{{ route('peserta.lomba.register', $perlombaan) }}">
                                @csrf
                                <button type="submit" class="inline-flex w-full items-center justify-center rounded-sm bg-gradient-to-r from-red-600 to-red-800 px-5 py-3.5 text-[12px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:scale-105 border border-transparent hover:border-amber-400 skew-x-[-10deg] transition-all">
                                    <span class="skew-x-[10deg]">Daftar Lomba Ini</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            </section>
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
                    
                    const rotateX = ((y - centerY) / centerY) * -5; 
                    const rotateY = ((x - centerX) / centerX) * 5;

                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.01)`;
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transition = 'transform 0.5s ease-out';
                    card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                });
            });
        });
    </script>
</x-app-layout>