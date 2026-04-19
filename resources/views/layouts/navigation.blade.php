<nav x-data="{ open: false }" class="relative z-[999] border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="relative overflow-visible mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200">
                            <img src="{{ asset('assets/logos/logo_kite_transp.png') }}" alt="Logo Kitelay" class="h-full w-full object-contain">
                        </div>
                        <div>
                            <p class="text-sm font-black tracking-[0.18em] text-slate-950">KITELAY</p>
                            <p class="text-[11px] uppercase tracking-[0.24em] text-slate-500">Competition Platform</p>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if (auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            Users
                        </x-nav-link>

                        <x-nav-link :href="route('admin.perlombaan.index')" :active="request()->routeIs('admin.perlombaan.*')">
                            Perlombaan
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->isJuri())
                        <x-nav-link :href="route('juri.penilaian.index')" :active="request()->routeIs('juri.penilaian.*')">
                            Penilaian
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->isPendaftar())
                        <x-nav-link :href="route('peserta.lomba.index')" :active="request()->routeIs('peserta.lomba.*')">
                            Lomba
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div x-data="{ profileOpen: false }" class="relative z-[1000] hidden overflow-visible sm:flex sm:items-center sm:ms-6">
                <button
                    type="button"
                    @click="profileOpen = !profileOpen"
                    @click.outside="profileOpen = false"
                    class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:text-slate-900"
                >
                    <div class="text-right">
                        <div class="font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs uppercase tracking-[0.2em] text-sky-600">{{ Auth::user()->role }}</div>
                    </div>

                    <svg class="h-4 w-4 fill-current transition" :class="{ 'rotate-180': profileOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div
                    x-show="profileOpen"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="absolute right-0 top-full z-[1100] mt-3 w-56 overflow-hidden rounded-2xl border border-slate-200 bg-white py-2 shadow-[0_25px_60px_-20px_rgba(15,23,42,0.35)] ring-1 ring-slate-200/70"
                >
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-slate-950">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="block w-full px-4 py-2 text-start text-sm text-slate-700 transition hover:bg-slate-50 hover:text-slate-950">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-200 bg-white sm:hidden">
        <div class="space-y-1 px-4 pb-3 pt-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            @if (auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    Users
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.perlombaan.index')" :active="request()->routeIs('admin.perlombaan.*')">
                    Perlombaan
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->isJuri())
                <x-responsive-nav-link :href="route('juri.penilaian.index')" :active="request()->routeIs('juri.penilaian.*')">
                    Penilaian
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->isPendaftar())
                <x-responsive-nav-link :href="route('peserta.lomba.index')" :active="request()->routeIs('peserta.lomba.*')">
                    Lomba
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="border-t border-slate-200 px-4 py-4">
            <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
            <div class="text-xs uppercase tracking-[0.2em] text-sky-600">{{ Auth::user()->role }}</div>
            <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="block w-full border-l-4 border-transparent px-3 py-2 text-start text-base font-medium text-gray-600 transition duration-150 ease-in-out hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 focus:border-gray-300 focus:bg-gray-50 focus:text-gray-800 focus:outline-none">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
