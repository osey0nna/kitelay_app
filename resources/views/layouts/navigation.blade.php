@php
    $currentUser = auth()->user();

    $adminFeatureLinks = [
        [
            'label' => 'Users',
            'route' => route('admin.users.index'),
            'active' => request()->routeIs('admin.users.*'),
        ],
        [
            'label' => 'Perlombaan',
            'route' => route('admin.perlombaan.index'),
            'active' => request()->routeIs('admin.perlombaan.*') && ! request()->routeIs('admin.perlombaan.hasil.*'),
        ],
        [
            'label' => 'Hasil',
            'route' => route('admin.hasil.index'),
            'active' => request()->routeIs('admin.hasil.*', 'admin.perlombaan.hasil.*'),
        ],
    ];
@endphp

<nav x-data="{ open: false }" class="relative z-[999] border-b border-red-900/50 bg-[#050505]/95 backdrop-blur-md shadow-[0_4px_20px_rgba(0,0,0,0.8)]">
    
    <div class="absolute top-0 inset-x-0 h-[1px] bg-gradient-to-r from-transparent via-red-600 to-transparent opacity-50"></div>

    <div class="relative overflow-visible mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="flex h-10 w-10 items-center justify-center overflow-hidden bg-gradient-to-br from-red-600 to-red-900 shadow-[0_0_15px_rgba(220,38,38,0.5)] transition-transform group-hover:scale-105 group-hover:shadow-[0_0_20px_rgba(251,191,36,0.4)] skew-x-[-10deg]">
                            <img src="{{ asset('assets/logos/logo_kite_transp.png') }}" alt="Logo Kitelay" class="h-7 w-7 object-contain invert brightness-0 saturate-100 skew-x-[10deg]">
                        </div>
                        <div>
                            <p class="text-[15px] font-black uppercase tracking-[0.2em] text-white group-hover:text-amber-400 transition-colors">KITELAY<span class="text-amber-400 group-hover:text-red-500">.</span></p>
                            <p class="text-[9px] font-bold uppercase tracking-[0.25em] text-slate-500">Competition Platform</p>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="relative inline-flex items-center px-1 pt-1 text-[13px] font-black uppercase tracking-widest transition-colors duration-300 group {{ request()->routeIs('dashboard') ? 'text-amber-400' : 'text-slate-400 hover:text-amber-400' }}">
                        Dashboard
                        <span class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-red-600 to-amber-400 transition-all duration-300 shadow-[0_0_8px_rgba(251,191,36,0.8)] {{ request()->routeIs('dashboard') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                    </a>

                    @if ($currentUser->isAdmin())
                        @foreach ($adminFeatureLinks as $link)
                            <a href="{{ $link['route'] }}" class="relative inline-flex items-center px-1 pt-1 text-[13px] font-black uppercase tracking-widest transition-colors duration-300 group {{ $link['active'] ? 'text-amber-400' : 'text-slate-400 hover:text-amber-400' }}">
                                {{ $link['label'] }}
                                <span class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-red-600 to-amber-400 transition-all duration-300 shadow-[0_0_8px_rgba(251,191,36,0.8)] {{ $link['active'] ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                            </a>
                        @endforeach
                    @endif

                    @if (auth()->user()->isJuri())
                        <a href="{{ route('juri.penilaian.index') }}" class="relative inline-flex items-center px-1 pt-1 text-[13px] font-black uppercase tracking-widest transition-colors duration-300 group {{ request()->routeIs('juri.penilaian.*') ? 'text-amber-400' : 'text-slate-400 hover:text-amber-400' }}">
                            Penilaian
                            <span class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-red-600 to-amber-400 transition-all duration-300 shadow-[0_0_8px_rgba(251,191,36,0.8)] {{ request()->routeIs('juri.penilaian.*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                        </a>
                    @endif

                    @if (auth()->user()->isPendaftar())
                        <a href="{{ route('peserta.lomba.index') }}" class="relative inline-flex items-center px-1 pt-1 text-[13px] font-black uppercase tracking-widest transition-colors duration-300 group {{ request()->routeIs('peserta.lomba.*') ? 'text-amber-400' : 'text-slate-400 hover:text-amber-400' }}">
                            Lomba
                            <span class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-red-600 to-amber-400 transition-all duration-300 shadow-[0_0_8px_rgba(251,191,36,0.8)] {{ request()->routeIs('peserta.lomba.*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                        </a>
                    @endif
                </div>
            </div>

            <div x-data="{ profileOpen: false }" class="relative z-[1000] hidden overflow-visible sm:flex sm:items-center sm:ms-6">
                <button
                    type="button"
                    @click="profileOpen = !profileOpen"
                    @click.outside="profileOpen = false"
                    class="inline-flex items-center gap-3 rounded-sm border border-neutral-800 bg-[#0a0a0c] px-4 py-2 text-sm font-medium transition hover:border-amber-500/50 hover:shadow-[0_0_15px_rgba(251,191,36,0.15)] group"
                >
                    <div class="text-right">
                        <div class="font-black uppercase tracking-wider text-white group-hover:text-amber-400 transition-colors">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-amber-600">{{ Auth::user()->role }}</div>
                    </div>

                    <svg class="h-4 w-4 fill-current text-slate-400 group-hover:text-amber-400 transition-transform" :class="{ 'rotate-180 text-amber-400': profileOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div
                    x-show="profileOpen"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                    class="absolute right-0 top-full z-[1100] mt-4 w-56 overflow-hidden rounded-xl border border-red-900/50 bg-[#0a0a0c] py-2 shadow-[0_15px_40px_rgba(220,38,38,0.2)]"
                >
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-[13px] font-bold uppercase tracking-widest text-slate-300 transition hover:bg-red-900/30 hover:text-amber-400 hover:pl-6 border-l-2 border-transparent hover:border-amber-400">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-3 text-start text-[13px] font-bold uppercase tracking-widest text-slate-300 transition hover:bg-red-900/30 hover:text-red-400 hover:pl-6 border-l-2 border-transparent hover:border-red-500">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl p-2 text-slate-400 transition hover:bg-neutral-800 hover:text-amber-400 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden transition-transform duration-300 rotate-90" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-collapse class="hidden border-t border-red-900/50 bg-[#0a0a0c] sm:hidden shadow-[0_20px_40px_rgba(0,0,0,0.8)] relative z-50">
        <div class="space-y-1 px-4 pb-3 pt-4">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-[14px] font-black uppercase tracking-wider transition-colors border-l-4 {{ request()->routeIs('dashboard') ? 'border-amber-400 bg-red-900/20 text-amber-400' : 'border-transparent text-slate-400 hover:border-red-500 hover:bg-neutral-900 hover:text-amber-400' }}">
                Dashboard
            </a>

                @if ($currentUser->isAdmin())
                    @foreach ($adminFeatureLinks as $link)
                        <a href="{{ $link['route'] }}" class="block px-4 py-3 text-[14px] font-black uppercase tracking-wider transition-colors border-l-4 {{ $link['active'] ? 'border-amber-400 bg-red-900/20 text-amber-400' : 'border-transparent text-slate-400 hover:border-red-500 hover:bg-neutral-900 hover:text-amber-400' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                @endif

            @if ($currentUser->isJuri())
                <a href="{{ route('juri.penilaian.index') }}" class="block px-4 py-3 text-[14px] font-black uppercase tracking-wider transition-colors border-l-4 {{ request()->routeIs('juri.penilaian.*') ? 'border-amber-400 bg-red-900/20 text-amber-400' : 'border-transparent text-slate-400 hover:border-red-500 hover:bg-neutral-900 hover:text-amber-400' }}">
                    Penilaian
                </a>
            @endif

            @if ($currentUser->isPendaftar())
                <a href="{{ route('peserta.lomba.index') }}" class="block px-4 py-3 text-[14px] font-black uppercase tracking-wider transition-colors border-l-4 {{ request()->routeIs('peserta.lomba.*') ? 'border-amber-400 bg-red-900/20 text-amber-400' : 'border-transparent text-slate-400 hover:border-red-500 hover:bg-neutral-900 hover:text-amber-400' }}">
                    Lomba
                </a>
            @endif
        </div>

        <div class="border-t border-neutral-800 px-4 py-5">
            <div class="font-black uppercase tracking-widest text-base text-white">{{ Auth::user()->name }}</div>
            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-amber-500 mt-1">{{ Auth::user()->role }}</div>
            <div class="text-xs font-medium text-slate-500 mt-1">{{ Auth::user()->email }}</div>

            <div class="mt-5 space-y-2">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-start text-[14px] font-bold uppercase tracking-wider text-slate-400 transition hover:bg-neutral-900 hover:text-amber-400 rounded-lg">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-3 py-2 text-start text-[14px] font-bold uppercase tracking-wider text-slate-400 transition hover:bg-red-900/30 hover:text-red-500 rounded-lg">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
