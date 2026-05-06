@php
    $onLandingPage = request()->url() === url('/');
    $landingSectionHref = fn (string $anchor) => $onLandingPage ? "#{$anchor}" : url('/')."#{$anchor}";
@endphp

<header x-data="{ 
        open: false, 
        exploreOpen: false, 
        mobileExploreOpen: false, 
        isScrolled: false,
        mounted: false 
    }" 
    x-init="setTimeout(() => mounted = true, 100)"
    @scroll.window="isScrolled = window.scrollY > 20"
    :class="{ 
        'shadow-[0_4px_20px_rgba(0,0,0,0.5)] border-red-600/20 bg-slate-950/95': isScrolled, 
        'border-transparent bg-transparent': !isScrolled,
        '-translate-y-full opacity-0': !mounted,
        'translate-y-0 opacity-100': mounted
    }"
    class="fixed inset-x-0 top-0 z-50 w-full backdrop-blur-md border-b transition-all duration-700 ease-out">
    
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-5">
            
            <a href="{{ url('/') }}" class="flex items-center gap-3 group relative">
                <div class="absolute inset-0 bg-red-600/20 rounded-xl blur-xl scale-50 opacity-0 group-hover:scale-150 group-hover:opacity-100 transition-all duration-500"></div>
                
                <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-700 shadow-[0_0_15px_rgba(220,38,38,0.5)] transition-all duration-300 group-hover:scale-110 group-hover:shadow-[0_0_25px_rgba(220,38,38,0.8)]">
                    <img src="{{ asset('assets/logos/logo_kite_transp.png') }}" 
                         alt="Logo Kitelay" 
                         class="h-10 w-10 object-contain invert brightness-0 saturate-100"> 
                </div>
    
                <span class="text-[22px] font-black tracking-widest text-white leading-none pt-1 transition-transform duration-300 group-hover:translate-x-1">
                    KITELAY<span class="text-red-600 animate-pulse">.</span>
                </span>
            </a>

            <nav class="hidden items-center gap-8 lg:flex">
                <a class="relative text-[14px] uppercase tracking-wider font-bold text-slate-300 transition-colors duration-300 hover:text-white after:absolute after:left-0 after:-bottom-2 after:h-[2px] after:w-0 after:bg-red-500 after:shadow-[0_0_8px_rgba(220,38,38,0.8)] after:transition-all after:duration-300 hover:after:w-full" href="{{ $landingSectionHref('beranda') }}">Beranda</a>
                <a class="relative text-[14px] uppercase tracking-wider font-bold text-slate-300 transition-colors duration-300 hover:text-white after:absolute after:left-0 after:-bottom-2 after:h-[2px] after:w-0 after:bg-red-500 after:shadow-[0_0_8px_rgba(220,38,38,0.8)] after:transition-all after:duration-300 hover:after:w-full" href="{{ $landingSectionHref('fitur') }}">Fitur</a>
                <a class="relative text-[14px] uppercase tracking-wider font-bold text-slate-300 transition-colors duration-300 hover:text-white after:absolute after:left-0 after:-bottom-2 after:h-[2px] after:w-0 after:bg-red-500 after:shadow-[0_0_8px_rgba(220,38,38,0.8)] after:transition-all after:duration-300 hover:after:w-full" href="{{ $landingSectionHref('alur') }}">Alur Sistem</a>
                
                <div class="relative" @keydown.escape.window="exploreOpen = false">
                    <button @click="exploreOpen = ! exploreOpen" @click.outside="exploreOpen = false" type="button" class="relative group flex items-center gap-1 text-[14px] uppercase tracking-wider font-bold text-slate-300 transition-colors duration-300 hover:text-white">
                        <span>Explore</span>
                        <span class="material-symbols-outlined text-base transition-transform duration-300 group-hover:text-red-500" :class="{ 'rotate-180 text-red-500': exploreOpen }">expand_more</span>
                        <span class="absolute -bottom-2 left-0 h-[2px] bg-red-500 shadow-[0_0_8px_rgba(220,38,38,0.8)] transition-all duration-300" :class="exploreOpen ? 'w-full' : 'w-0'"></span>
                    </button>

                    <div
                        x-cloak
                        x-show="exploreOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                        class="absolute right-0 top-full z-50 mt-6 w-56 rounded-xl border border-slate-800 bg-slate-950/90 backdrop-blur-xl p-2 shadow-[0_10px_40px_rgba(0,0,0,0.8)] overflow-hidden"
                    >
                        <div class="space-y-1 relative">
                            <div class="absolute left-0 top-0 bottom-0 w-[2px] bg-gradient-to-b from-red-600 to-transparent rounded-full"></div>
                            
                            <a @click="exploreOpen = false" href="{{ route('explore.index') }}" class="group flex items-center gap-2 rounded-lg px-4 py-3 text-[14px] font-bold tracking-wide text-slate-300 transition-all hover:bg-red-600/10 hover:text-red-400 hover:translate-x-1">
                                <span class="material-symbols-outlined text-[18px] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0 text-red-500">sports_esports</span>
                                Lomba
                            </a>
                            <a @click="exploreOpen = false" href="{{ route('pengumuman.index') }}" class="group flex items-center gap-2 rounded-lg px-4 py-3 text-[14px] font-bold tracking-wide text-slate-300 transition-all hover:bg-red-600/10 hover:text-red-400 hover:translate-x-1">
                                <span class="material-symbols-outlined text-[18px] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0 text-red-500">campaign</span>
                                Pengumuman
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="hidden items-center gap-6 lg:flex">
                <a href="{{ route('login') }}" class="relative text-[14px] uppercase tracking-wider font-bold text-slate-400 transition-colors hover:text-white group">
                    Masuk
                    <span class="absolute -bottom-1 left-1/2 w-0 h-[2px] bg-white transition-all duration-300 group-hover:w-full group-hover:left-0 group-hover:shadow-[0_0_8px_rgba(255,255,255,0.8)]"></span>
                </a>
                <a href="{{ route('register') }}" class="relative overflow-hidden inline-flex items-center justify-center rounded-full bg-gradient-to-r from-red-600 to-red-800 px-7 py-2.5 text-[14px] uppercase tracking-wider font-black text-white transition-all duration-300 hover:scale-105 shadow-[0_0_15px_rgba(220,38,38,0.4)] hover:shadow-[0_0_30px_rgba(220,38,38,0.7)] group">
                    <span class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shine_1s_ease-in-out]"></span>
                    Daftar
                </a>
            </div>

            <button @click="open = !open" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-300 transition-colors hover:bg-slate-800 hover:text-white lg:hidden">
                <span class="material-symbols-outlined transition-transform duration-300" :class="{'rotate-90 scale-0': open, 'rotate-0 scale-100': !open}">menu</span>
                <span class="material-symbols-outlined absolute transition-transform duration-300" :class="{'rotate-0 scale-100 text-red-500': open, '-rotate-90 scale-0': !open}">close</span>
            </button>
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-10" class="border-t border-slate-800/80 bg-slate-950/95 backdrop-blur-2xl px-4 py-6 shadow-[0_20px_40px_rgba(0,0,0,0.8)] lg:hidden rounded-b-3xl absolute inset-x-0 top-full">
            <nav class="flex flex-col gap-2">
                <a @click="open = false" class="rounded-xl px-4 py-3 text-[15px] font-bold uppercase tracking-wide text-slate-300 transition-all hover:bg-red-600/10 hover:text-red-500 hover:pl-6 border-l-2 border-transparent hover:border-red-500" href="{{ $landingSectionHref('beranda') }}">Beranda</a>
                <a @click="open = false" class="rounded-xl px-4 py-3 text-[15px] font-bold uppercase tracking-wide text-slate-300 transition-all hover:bg-red-600/10 hover:text-red-500 hover:pl-6 border-l-2 border-transparent hover:border-red-500" href="{{ $landingSectionHref('fitur') }}">Fitur</a>
                <a @click="open = false" class="rounded-xl px-4 py-3 text-[15px] font-bold uppercase tracking-wide text-slate-300 transition-all hover:bg-red-600/10 hover:text-red-500 hover:pl-6 border-l-2 border-transparent hover:border-red-500" href="{{ $landingSectionHref('alur') }}">Alur Sistem</a>

                <div class="rounded-xl px-2 py-1 transition-colors" :class="{'bg-slate-900/50': mobileExploreOpen}">
                    <button @click="mobileExploreOpen = ! mobileExploreOpen" type="button" class="flex w-full items-center justify-between rounded-xl px-2 py-3 text-[15px] font-bold uppercase tracking-wide text-slate-300 transition-all hover:text-red-500">
                        <span>Explore</span>
                        <span class="material-symbols-outlined text-base transition-transform duration-300" :class="{ 'rotate-180 text-red-500': mobileExploreOpen }">expand_more</span>
                    </button>

                    <div x-show="mobileExploreOpen" x-collapse x-transition.duration.300ms class="space-y-1 border-l-2 border-red-900/50 ml-4 mt-1">
                        <a @click="open = false; mobileExploreOpen = false" class="block rounded-r-lg px-4 py-2 text-[14px] font-medium text-slate-400 transition-all hover:text-red-400 hover:bg-red-900/20" href="{{ route('explore.index') }}">Lomba</a>
                        <a @click="open = false; mobileExploreOpen = false" class="block rounded-r-lg px-4 py-2 text-[14px] font-medium text-slate-400 transition-all hover:text-red-400 hover:bg-red-900/20" href="{{ route('pengumuman.index') }}">Pengumuman</a>
                    </div>
                </div>
            </nav>

            <div class="mt-6 flex flex-col gap-3 pt-6 border-t border-slate-800/50">
                <a href="{{ route('login') }}" class="flex items-center justify-center rounded-xl border border-slate-700 bg-transparent px-5 py-3.5 text-[14px] uppercase tracking-widest font-bold text-slate-300 transition-all hover:bg-slate-800 hover:text-white">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="flex items-center justify-center rounded-xl bg-gradient-to-r from-red-600 to-red-800 px-5 py-3.5 text-[14px] uppercase tracking-widest font-black text-white transition-all shadow-[0_0_20px_rgba(220,38,38,0.3)] hover:shadow-[0_0_30px_rgba(220,38,38,0.6)]">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</header>