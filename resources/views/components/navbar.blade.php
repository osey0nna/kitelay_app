@php
    $onLandingPage = request()->url() === url('/');
    $landingSectionHref = fn (string $anchor) => $onLandingPage ? "#{$anchor}" : url('/')."#{$anchor}";
@endphp

<header x-data="{ 
        open: false, 
        exploreOpen: false, 
        mobileExploreOpen: false, 
        isScrolled: false 
    }" 
    @scroll.window="isScrolled = window.scrollY > 20"
    :class="{ 'shadow-lg shadow-[#1e2460]/10 border-transparent': isScrolled, 'border-slate-100': !isScrolled }"
    class="fixed inset-x-0 top-0 z-50 w-full bg-white/95 backdrop-blur-md border-b transition-all duration-300">
    
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-5 ">
            
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#1e2460] shadow-sm">
                    <img src="{{ asset('assets/logos/logo_kite_transp.png') }}" 
                         alt="Logo Kitelay" 
                         class="h-10 w-10 object-contain invert brightness-0 saturate-100"> 
                </div>
    
                <span class="text-[22px] font-bold tracking-tight text-slate-900 leading-none pt-1">
                    KITELAY
                </span>
    
            </a>

            <nav class="hidden items-center gap-8 lg:flex">
                <a class="text-[15px] font-semibold text-slate-500 transition hover:text-indigo-800" href="{{ $landingSectionHref('beranda') }}">Beranda</a>
                <a class="text-[15px] font-semibold text-slate-500 transition hover:text-indigo-800" href="{{ $landingSectionHref('fitur') }}">Fitur</a>
                <a class="text-[15px] font-semibold text-slate-500 transition hover:text-indigo-800" href="{{ $landingSectionHref('alur') }}">Alur Sistem</a>
                
                <div class="relative" @keydown.escape.window="exploreOpen = false">
                    <button @click="exploreOpen = ! exploreOpen" type="button" class="inline-flex items-center gap-1 text-[15px] font-semibold text-slate-500 transition hover:text-indigo-800">
                        Explore
                        <span class="material-symbols-outlined text-base transition" :class="{ 'rotate-180': exploreOpen }">expand_more</span>
                    </button>

                    <div
                        x-cloak
                        x-show="exploreOpen"
                        x-transition.opacity.duration.200ms
                        @click.outside="exploreOpen = false"
                        class="absolute right-0 top-full z-50 mt-4 w-48 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl shadow-slate-200/40"
                    >
                        <div class="space-y-1">
                            <a @click="exploreOpen = false" href="{{ route('explore.index') }}" class="block rounded-xl px-4 py-2.5 text-[14px] font-medium text-slate-600 transition hover:bg-slate-50 hover:text-indigo-800">
                                Lomba
                            </a>
                            <a @click="exploreOpen = false" href="{{ route('pengumuman.index') }}" class="block rounded-xl px-4 py-2.5 text-[14px] font-medium text-slate-600 transition hover:bg-slate-50 hover:text-indigo-800">
                                Pengumuman
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="hidden items-center gap-6 lg:flex">
                <a href="{{ route('login') }}" class="text-[15px] font-semibold text-slate-600 transition hover:text-slate-900">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-[#1e2460] px-6 py-2.5 text-[15px] font-semibold text-white transition hover:bg-[#141842] shadow-md shadow-indigo-900/20">
                    Daftar
                </a>
            </div>

            <button @click="open = !open" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100 lg:hidden">
                <span class="material-symbols-outlined" x-show="!open">menu</span>
                <span class="material-symbols-outlined" x-show="open" x-cloak>close</span>
            </button>
        </div>

        <div x-show="open" x-transition class="border-t border-slate-100 bg-white/95 backdrop-blur-md px-2 py-4 shadow-lg lg:hidden rounded-b-2xl absolute inset-x-0 top-full">
            <nav class="flex flex-col gap-1">
                <a @click="open = false" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-600 transition hover:bg-slate-50 hover:text-indigo-800" href="{{ $landingSectionHref('beranda') }}">Beranda</a>
                <a @click="open = false" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-600 transition hover:bg-slate-50 hover:text-indigo-800" href="{{ $landingSectionHref('fitur') }}">Fitur</a>
                <a @click="open = false" class="rounded-xl px-4 py-3 text-[15px] font-medium text-slate-600 transition hover:bg-slate-50 hover:text-indigo-800" href="{{ $landingSectionHref('alur') }}">Alur Sistem</a>

                <div class="px-2 py-1">
                    <button @click="mobileExploreOpen = ! mobileExploreOpen" type="button" class="flex w-full items-center justify-between rounded-xl px-2 py-2 text-[15px] font-medium text-slate-600 transition hover:text-indigo-800">
                        <span>Explore</span>
                        <span class="material-symbols-outlined text-base transition" :class="{ 'rotate-180': mobileExploreOpen }">expand_more</span>
                    </button>

                    <div x-cloak x-show="mobileExploreOpen" x-transition class="mt-1 ml-4 space-y-1 border-l-2 border-slate-100 pl-2">
                        <a @click="open = false; mobileExploreOpen = false" class="block rounded-lg px-3 py-2 text-[14px] font-medium text-slate-500 transition hover:text-indigo-800" href="{{ route('explore.index') }}">Lomba</a>
                        <a @click="open = false; mobileExploreOpen = false" class="block rounded-lg px-3 py-2 text-[14px] font-medium text-slate-500 transition hover:text-indigo-800" href="{{ route('pengumuman.index') }}">Pengumuman</a>
                    </div>
                </div>
            </nav>

            <div class="mt-4 flex flex-col gap-3 px-2">
                <a href="{{ route('login') }}" class="flex items-center justify-center rounded-xl px-5 py-3 text-[15px] font-semibold text-slate-700 transition hover:bg-slate-50">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="flex items-center justify-center rounded-full bg-[#1e2460] px-5 py-3 text-[15px] font-semibold text-white transition hover:bg-[#141842]">
                    Daftar
                </a>
            </div>
        </div>
    </div>
</header>