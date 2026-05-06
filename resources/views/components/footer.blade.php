<footer class="bg-black relative overflow-hidden border-t border-red-900/50 pt-16 pb-12">
    
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[120px] pointer-events-none -z-0"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-4 lg:gap-8">
            
            <div class="lg:col-span-2">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="flex h-10 w-10 items-center justify-center rounded-sm bg-gradient-to-br from-red-600 to-red-900 shadow-[0_0_15px_rgba(220,38,38,0.5)] skew-x-[-10deg]">
                        <img src="{{ asset('assets/logos/logo_kite_transp.png') }}" alt="Logo" class="h-8 w-8 object-contain invert brightness-0 saturate-100 skew-x-[10deg]"> 
                    </div>
                    <span class="text-[22px] font-black tracking-widest text-white leading-none uppercase">
                        KITELAY<span class="text-amber-400">.</span>
                    </span>
                </a>
                
                <h2 class="mt-8 max-w-md text-2xl font-black uppercase tracking-wide text-white leading-tight">
                    Bangun Pengalaman Perlombaan Yang Lebih <span class="text-amber-400">Tajam.</span>
                </h2>
            </div>

            <div>
                <h3 class="text-[13px] font-black uppercase tracking-widest text-amber-500 mb-6">Navigasi</h3>
                <ul class="space-y-4">
                    <li><a href="{{ url('/') }}#beranda" class="text-[14px] font-bold uppercase tracking-wider text-slate-400 transition-colors hover:text-amber-400 flex items-center gap-2 group"><span class="w-2 h-[2px] bg-red-600 group-hover:bg-amber-400 transition-colors"></span> Beranda</a></li>
                    <li><a href="{{ url('/') }}#fitur" class="text-[14px] font-bold uppercase tracking-wider text-slate-400 transition-colors hover:text-amber-400 flex items-center gap-2 group"><span class="w-2 h-[2px] bg-red-600 group-hover:bg-amber-400 transition-colors"></span> Fitur</a></li>
                    <li><a href="{{ url('/') }}#alur" class="text-[14px] font-bold uppercase tracking-wider text-slate-400 transition-colors hover:text-amber-400 flex items-center gap-2 group"><span class="w-2 h-[2px] bg-red-600 group-hover:bg-amber-400 transition-colors"></span> Alur Sistem</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-[13px] font-black uppercase tracking-widest text-amber-500 mb-6">Explore</h3>
                <ul class="space-y-4">
                    <li><a href="{{ route('explore.index') }}" class="text-[14px] font-bold uppercase tracking-wider text-slate-400 transition-colors hover:text-amber-400 flex items-center gap-2 group"><span class="w-2 h-[2px] bg-red-600 group-hover:bg-amber-400 transition-colors"></span> Lomba Aktif</a></li>
                    <li><a href="{{ route('pengumuman.index') }}" class="text-[14px] font-bold uppercase tracking-wider text-slate-400 transition-colors hover:text-amber-400 flex items-center gap-2 group"><span class="w-2 h-[2px] bg-red-600 group-hover:bg-amber-400 transition-colors"></span> Pengumuman</a></li>
                </ul>
            </div>

        </div>

        <div class="mt-16 border-t border-neutral-800/80 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[12px] font-bold uppercase tracking-widest text-slate-600">
                &copy; {{ date('Y') }} KITELAY S17. All rights reserved.
            </p>
            <div class="flex gap-4">
                <a href="#" class="text-slate-600 hover:text-amber-400 transition-colors"><span class="material-symbols-outlined text-[20px]">language</span></a>
                <a href="#" class="text-slate-600 hover:text-amber-400 transition-colors"><span class="material-symbols-outlined text-[20px]">share</span></a>
            </div>
        </div>
    </div>
</footer>