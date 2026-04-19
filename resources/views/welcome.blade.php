@extends('layouts.landing')

@section('title', 'Kompetisi Kreatif SMK 2026')

@section('content')
<section id="beranda" class="relative overflow-hidden bg-white pt-24 pb-20 scroll-mt-28">
    <div class="mx-auto max-w-7xl px-4 pt-10 sm:px-6 lg:px-8 lg:pt-16">
        <div class="grid items-center gap-14 lg:grid-cols-2 lg:gap-16">

            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-[12px] font-semibold text-slate-700">
                    <span class="material-symbols-outlined text-[16px] text-[#1e2460]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                    Kompetisi Kreatif SMK 2026
                </div>

                <div class="space-y-6">
                    <h1 class="max-w-4xl text-[40px] font-bold leading-[1.15] tracking-tight text-slate-900 sm:text-[52px] lg:text-[60px]">
                        Wujudkan ide kreatifmu,
                        <span class="bg-gradient-to-r from-[#1e2460] to-indigo-600 bg-clip-text text-transparent">
                        jadikan prestasi nyata.
                        </span>
                    </h1>
                    <p class="max-w-xl text-[17px] leading-relaxed text-slate-500">
                        Kitelay membantu peserta mendaftar lomba dan upload karya, juri memberi penilaian berbobot, dan admin memantau ranking serta podium dalam satu platform terpusat.
                    </p>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    <a href="{{ route('register') }}" class="inline-flex h-13 items-center justify-center gap-2 rounded-full bg-[#1e2460] px-8 py-3.5 text-[15px] font-semibold text-white transition hover:-translate-y-0.5 hover:bg-[#141842] shadow-lg shadow-indigo-900/20">
                        Ikuti Lomba
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex h-13 items-center justify-center rounded-full border border-slate-200 bg-white px-8 py-3.5 text-[15px] font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:bg-slate-50">
                        Login Dashboard
                    </a>
                </div>
            </div>

            <div class="relative flex justify-center lg:justify-end">
                <div class="absolute -inset-10 rounded-full bg-gradient-to-br from-indigo-50 to-slate-100 blur-3xl opacity-80"></div>

                <div class="relative z-10 w-full max-w-xl rounded-[2.5rem] bg-white p-3 sm:p-5 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)] ring-1 ring-slate-100">
                    <img src="{{ asset('assets/images/hero_image3.jpg') }}"
                         alt="Ilustrasi Platform Kitelay"
                         class="h-auto w-full rounded-[1.75rem] object-cover">
                </div>
            </div>

        </div>
    </div>
</section>

<section id="fitur" class="bg-slate-50 py-20 sm:py-28 scroll-mt-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-[32px] font-bold tracking-tight text-slate-900 sm:text-[40px]">
                Semua kebutuhan kompetisi digital dirangkum dalam satu platform.
            </h2>
            <p class="mt-5 text-[17px] text-slate-500">Sistem terintegrasi yang nyaman digunakan di berbagai ukuran layar.</p>
        </div>

        <div class="mt-16 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl bg-white p-8 shadow-sm transition hover:shadow-md hover:-translate-y-1">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-[#1e2460]">
                    <span class="material-symbols-outlined">fact_check</span>
                </div>
                <h3 class="mt-6 text-[18px] font-semibold text-slate-900">Pendaftaran Cepat</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-slate-500">Peserta bisa memilih lomba dan mendaftar tanpa alur yang membingungkan.</p>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow-sm transition hover:shadow-md hover:-translate-y-1">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-[#1e2460]">
                    <span class="material-symbols-outlined">upload_file</span>
                </div>
                <h3 class="mt-6 text-[18px] font-semibold text-slate-900">Submission Mudah</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-slate-500">Upload karya dan edit submission sudah nyaman digunakan di HP maupun laptop.</p>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow-sm transition hover:shadow-md hover:-translate-y-1">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-[#1e2460]">
                    <span class="material-symbols-outlined">analytics</span>
                </div>
                <h3 class="mt-6 text-[18px] font-semibold text-slate-900">Penilaian Jelas</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-slate-500">Juri menilai berdasarkan kriteria berbobot dan skor akhir bisa dirata-ratakan.</p>
            </div>
            <div class="rounded-3xl bg-white p-8 shadow-sm transition hover:shadow-md hover:-translate-y-1">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-[#1e2460]">
                    <span class="material-symbols-outlined">workspace_premium</span>
                </div>
                <h3 class="mt-6 text-[18px] font-semibold text-slate-900">Hasil Transparan</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-slate-500">Ranking dan podium dipantau dengan tampilan yang jauh lebih bersih.</p>
            </div>
        </div>
    </div>
</section>

<section id="alur" class="bg-white py-20 sm:py-28 scroll-mt-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-[32px] font-bold tracking-tight text-slate-900 sm:text-[40px]">
                Alur Sistem
            </h2>
            <p class="mt-5 text-[17px] text-slate-500">Dari pendaftaran sampai podium, tiap tahap dibuat lebih intuitif dan rapi.</p>
        </div>

        <div class="mt-16 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-8 text-center transition hover:bg-white hover:shadow-md hover:-translate-y-1">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-xl font-bold text-[#1e2460] shadow-sm">1</div>
                <h3 class="mt-6 text-[18px] font-semibold text-slate-900">Daftar Akun</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-slate-500">Peserta membuat akun dan memilih lomba yang tersedia.</p>
            </div>
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-8 text-center transition hover:bg-white hover:shadow-md hover:-translate-y-1">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-xl font-bold text-[#1e2460] shadow-sm">2</div>
                <h3 class="mt-6 text-[18px] font-semibold text-slate-900">Kirim Karya</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-slate-500">Submission dikumpulkan langsung melalui dashboard peserta.</p>
            </div>
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-8 text-center transition hover:bg-white hover:shadow-md hover:-translate-y-1">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-xl font-bold text-[#1e2460] shadow-sm">3</div>
                <h3 class="mt-6 text-[18px] font-semibold text-slate-900">Penilaian Juri</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-slate-500">Juri memberi skor per kriteria dengan bobot yang telah disesuaikan.</p>
            </div>
            <div class="rounded-3xl border border-slate-100 bg-slate-50 p-8 text-center transition hover:bg-white hover:shadow-md hover:-translate-y-1">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-xl font-bold text-[#1e2460] shadow-sm">4</div>
                <h3 class="mt-6 text-[18px] font-semibold text-slate-900">Pengumuman</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-slate-500">Admin dan peserta dapat melihat ranking serta pemenang lomba secara transparan.</p>
            </div>
        </div>
    </div>
</section>

<section id="mulai" class="bg-white py-12 pb-24 scroll-mt-24">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-[2.5rem] bg-[#1e2460] px-6 py-16 text-center shadow-2xl shadow-indigo-900/15 sm:px-12 sm:py-20 relative overflow-hidden">
            <div class="absolute -left-10 top-0 h-40 w-40 rounded-full bg-white/5 blur-2xl"></div>
            <div class="absolute -right-10 bottom-0 h-40 w-40 rounded-full bg-white/5 blur-2xl"></div>

            <div class="relative z-10">
                <h2 class="text-[32px] font-bold tracking-tight text-white sm:text-[40px]">
                    Siap menunjukkan bakat terbaikmu?
                </h2>
                <p class="mx-auto mt-5 max-w-2xl text-[17px] leading-relaxed text-indigo-100">
                    Daftar sekarang, ikuti kompetisi yang sedang dibuka, dan pantau perjalanan prestasimu sampai ke podium.
                </p>
                <div class="mt-10 flex flex-col justify-center gap-4 sm:flex-row">
                    <a href="{{ route('register') }}" class="inline-flex h-13 items-center justify-center rounded-full bg-white px-8 py-3.5 text-[15px] font-semibold text-[#1e2460] transition hover:bg-slate-100">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection