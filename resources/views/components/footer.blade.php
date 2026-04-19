@php
    $onLandingPage = request()->url() === url('/');
    $landingSectionHref = fn (string $anchor) => $onLandingPage ? "#{$anchor}" : url('/')."#{$anchor}";
@endphp

<footer class="mt-20 border-t border-slate-200 bg-slate-50">
    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8">
        
        <div class="grid gap-12 lg:grid-cols-2 lg:gap-8">
            
            <div class="max-w-xl">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#1e2460] shadow-sm">
                        <img src="{{ asset('assets/logos/logo_kite_transp.png') }}" alt="Logo Kitelay" class="h-12 w-12 object-contain invert brightness-0">
                    </div>
                    <p class="text-xl font-bold tracking-tight text-slate-900 uppercase">KITELAY</p>
                </div>

                <h2 class="mt-8 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Bangun pengalaman perlombaan yang lebih rapi.
                </h2>
                <p class="mt-4 text-base leading-relaxed text-slate-500">
                    Kelola pendaftaran, submission, penilaian, hingga pengumuman dalam satu platform digital yang modern dan mudah dipakai.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#1e2460] px-7 py-3 text-[15px] font-semibold text-white transition hover:-translate-y-0.5 hover:bg-[#141842] shadow-sm shadow-indigo-900/10">
                        Daftar Sekarang
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-7 py-3 text-[15px] font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:bg-slate-50 hover:text-slate-900">
                        Login Dashboard
                    </a>
                </div>
            </div>

            <div class="lg:flex lg:justify-end lg:pt-4">
                <div class="min-w-[200px]">
                    <p class="text-sm font-bold uppercase tracking-widest text-slate-900">Navigasi</p>
                    <nav class="mt-6 flex flex-col space-y-3.5">
                        <a class="text-[15px] font-medium text-slate-500 transition hover:text-[#1e2460]" href="{{ $landingSectionHref('beranda') }}">Beranda</a>
                        <a class="text-[15px] font-medium text-slate-500 transition hover:text-[#1e2460]" href="{{ $landingSectionHref('fitur') }}">Fitur</a>
                        <a class="text-[15px] font-medium text-slate-500 transition hover:text-[#1e2460]" href="{{ $landingSectionHref('alur') }}">Alur Sistem</a>
                        <a class="text-[15px] font-medium text-slate-500 transition hover:text-[#1e2460]" href="{{ route('explore.index') }}">Lomba</a>
                        <a class="text-[15px] font-medium text-slate-500 transition hover:text-[#1e2460]" href="{{ route('pengumuman.index') }}">Pengumuman</a>
                    </nav>
                </div>
            </div>
            
        </div>

        <div class="mt-16 flex flex-col gap-4 border-t border-slate-100 pt-8 text-sm font-medium text-slate-400 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} Kitelay. Platform manajemen perlombaan digital.</p>
            
            <div class="flex flex-wrap items-center gap-6">
                <a href="{{ route('syarat-ketentuan') }}" class="transition hover:text-[#1e2460]">Syarat & Ketentuan</a>
                <a href="#" class="transition hover:text-[#1e2460]">Kebijakan Privasi</a>
                <a href="#" class="transition hover:text-[#1e2460]">FAQ</a>
            </div>
        </div>
        
    </div>
</footer>