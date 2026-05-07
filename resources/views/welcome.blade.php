@extends('layouts.landing')

@section('title', 'Kompetisi Kreatif SMK 2026')

@section('content')
<section id="beranda" class="relative overflow-hidden bg-black pt-24 pb-20 scroll-mt-28 border-b border-red-900/30 text-white">
    
    <div id="cursor-glow" class="absolute w-[500px] h-[500px] bg-amber-500/15 rounded-full blur-[100px] pointer-events-none -translate-x-1/2 -translate-y-1/2 transition-opacity duration-300 opacity-0 z-0"></div>

    <div class="mx-auto max-w-7xl px-4 pt-8 md:pt-10 lg:pt-16 md:px-6 lg:px-8 relative z-10">
        <div class="grid items-center gap-14 lg:grid-cols-2 lg:gap-16">

            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 rounded-none border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-black px-4 py-2 text-[12px] font-black uppercase tracking-widest text-white backdrop-blur-sm">
                    <span class="material-symbols-outlined text-[16px] text-amber-400" style="font-variation-settings: 'FILL' 1;">emoji_events</span>
                    Kompetisi Kreatif SMK 2026
                </div>

                <div class="space-y-6">
                    <h1 class="max-w-4xl text-3xl md:text-[44px] lg:text-[60px] font-black leading-[1.1] tracking-tight text-white uppercase">
                        Wujudkan ide kreatifmu,
                        <span class="block bg-gradient-to-r from-red-500 via-red-600 to-amber-400 bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(251,191,36,0.3)] mt-2">
                            jadikan prestasi nyata.
                        </span>
                    </h1>
                    <p class="max-w-xl text-base md:text-[16px] font-medium leading-relaxed text-white/90">
                        Kitelay membantu peserta mendaftar lomba dan upload karya, juri memberi penilaian berbobot, dan admin memantau ranking serta podium dalam satu platform terpusat.
                    </p>
                </div>

                <div class="flex flex-col gap-4 md:flex-row md:items-center">
                    <a href="{{ route('register') }}" class="group relative inline-flex h-13 items-center justify-center bg-gradient-to-br from-red-600 to-red-800 px-8 py-3.5 transition-all duration-300 hover:scale-105 shadow-[0_0_20px_rgba(220,38,38,0.4)] hover:shadow-[0_0_30px_rgba(251,191,36,0.5)] border border-transparent hover:border-amber-400 skew-x-[-12deg]">
                        <div class="flex items-center gap-2 skew-x-[12deg] text-[15px] font-black uppercase tracking-widest text-white">
                            Ikuti Lomba
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </div>
                    </a>
                    <a href="{{ route('login') }}" class="group relative inline-flex h-13 items-center justify-center border border-white/20 bg-black/50 px-8 py-3.5 transition-all duration-300 hover:border-amber-400 hover:bg-amber-400/10 backdrop-blur-sm skew-x-[-12deg]">
                        <span class="skew-x-[12deg] text-[15px] font-bold uppercase tracking-widest text-white">
                            Login Dashboard
                        </span>
                    </a>
                </div>
            </div>

            <div class="relative flex justify-center lg:justify-end">
                <div class="absolute -inset-10 rounded-full bg-red-700/20 blur-[100px] opacity-80 pointer-events-none"></div>
                <div class="relative z-10 w-full max-w-xl bg-[#0a0a0c] p-3 sm:p-5 shadow-[0_0_40px_rgba(220,38,38,0.2)] ring-1 ring-red-900/50 hover:ring-amber-500/50 transition-all duration-500 hover:shadow-[0_0_40px_rgba(251,191,36,0.2)] rounded-tl-3xl rounded-br-3xl">
                    <img src="{{ asset('assets/images/hero_image4.png') }}" alt="Ilustrasi Platform Kitelay" class="h-auto w-full object-cover transition-opacity rounded-tl-[1.25rem] rounded-br-[1.25rem] filter grayscale hover:grayscale-0">
                </div>
            </div>

        </div>
    </div>
</section>

<section id="fitur" class="bg-[#050505] py-20 sm:py-28 scroll-mt-24 border-y border-red-900/30 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-2xl md:text-[32px] lg:text-[40px] font-black uppercase tracking-tight text-white">
                Kebutuhan Kompetisi <span class="text-amber-400">Satu Platform</span>
            </h2>
            <p class="mt-4 md:mt-5 text-sm md:text-[16px] text-white/80 font-medium">Sistem terintegrasi yang nyaman digunakan di berbagai ukuran layar dengan performa maksimal.</p>
        </div>

        <div class="mt-12 md:mt-16 grid gap-6 md:gap-8 md:grid-cols-2 xl:grid-cols-4">
            @foreach(['Daftar Cepat', 'Submit Mudah', 'Penilaian Jelas', 'Hasil Transparan'] as $fitur)
            <div class="bg-[#0a0a0c] p-8 shadow-lg border border-neutral-800 transition-all duration-300 hover:border-amber-500/70 hover:shadow-[0_0_30px_rgba(251,191,36,0.15)] hover:-translate-y-2 group rounded-tl-2xl rounded-br-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-red-600 transition-all duration-300 group-hover:bg-amber-400"></div>
                <h3 class="mt-8 text-[18px] font-black uppercase tracking-wide text-white">{{ $fitur }}</h3>
                <p class="mt-3 text-[14px] leading-relaxed text-white/80 font-medium">Sistem terintegrasi untuk memudahkan segala alur kompetisi Anda.</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="alur" class="bg-black py-20 sm:py-28 scroll-mt-24 text-white">
    <div class="mx-auto max-w-7xl px-4 md:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-2xl md:text-[32px] lg:text-[40px] font-black uppercase tracking-tight text-white">Alur <span class="text-amber-400">Sistem</span></h2>
        </div>
        <div class="mt-12 md:mt-16 grid gap-6 md:gap-8 md:grid-cols-2 xl:grid-cols-4 relative text-white">
             @for($i=1; $i<=4; $i++)
             <div class="relative z-10 border border-neutral-800 bg-[#0a0a0c] p-8 text-center transition-all duration-300 hover:border-amber-500/70 group skew-x-[-5deg]">
                <div class="skew-x-[5deg]">
                    <h3 class="mt-8 text-[18px] font-black uppercase tracking-wide text-white">Tahap {{ $i }}</h3>
                    <p class="mt-3 text-[14px] leading-relaxed text-white/80">Penjelasan alur kerja sistem tahap {{ $i }}.</p>
                </div>
            </div>
             @endfor
        </div>
    </div>
</section>

<section id="mulai" class="bg-[#050505] py-12 pb-24 border-t border-red-900/30 text-white">
    <div class="mx-auto max-w-5xl px-4 md:px-6 lg:px-8 relative">
        <div class="bg-gradient-to-br from-[#0a0a0c] via-[#110505] to-[#050505] border border-amber-500/30 px-6 py-12 md:px-12 md:py-20 text-center shadow-[0_0_50px_rgba(251,191,36,0.15)] relative overflow-hidden group transition-all duration-700 skew-x-[-3deg] ring-1 ring-white/5 z-10">
            <h2 class="text-2xl md:text-[32px] lg:text-[40px] font-black uppercase tracking-tight text-white">Siap Menjadi <span class="text-amber-400">Juara?</span></h2>
            <p class="mx-auto mt-4 md:mt-5 max-w-2xl text-sm md:text-[16px] leading-relaxed text-white/80 font-medium">Daftar sekarang dan mulailah perjalanan prestasimu.</p>
            <div class="mt-10">
                <a href="{{ route('register') }}" class="inline-flex h-13 items-center justify-center bg-gradient-to-r from-amber-500 to-orange-600 px-10 py-4 text-[15px] font-black uppercase tracking-widest text-black transition-all hover:scale-110 skew-x-[-12deg]">
                    <span class="skew-x-[12deg]">Daftar Sekarang</span>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // Script animasi glow tetap terjaga
    document.addEventListener('DOMContentLoaded', () => {
        const heroArea = document.getElementById('beranda');
        const glow = document.getElementById('cursor-glow');
        heroArea.addEventListener('mousemove', (e) => {
            const rect = heroArea.getBoundingClientRect();
            glow.style.left = `${e.clientX - rect.left}px`;
            glow.style.top = `${e.clientY - rect.top}px`;
        });
        heroArea.addEventListener('mouseenter', () => glow.classList.replace('opacity-0', 'opacity-100'));
        heroArea.addEventListener('mouseleave', () => glow.classList.replace('opacity-100', 'opacity-0'));
    });
</script>
@endsection