@extends('layouts.landing')

@section('title', 'Syarat & Ketentuan')

@section('content')
<section class="bg-slate-50 pt-20 md:pt-32 pb-12">
    <div class="mx-auto max-w-3xl px-4 md:px-6 lg:px-8 text-center">
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight text-slate-900">Syarat & Ketentuan</h1>
        <p class="mt-4 text-[16px] text-slate-500">Pembaruan terakhir: {{ now()->translatedFormat('d F Y') }}</p>
    </div>
</section>

<section class="bg-white py-12 md:py-16">
    <div class="mx-auto max-w-3xl px-4 md:px-6 lg:px-8">
        <div class="space-y-10 text-[16px] leading-relaxed text-slate-600">
            
            <div>
                <h2 class="text-xl font-bold text-slate-900">1. Pendahuluan</h2>
                <p class="mt-3">
                    Selamat datang di Kitelay. Dengan mendaftar dan menggunakan platform ini, Anda menyetujui seluruh syarat dan ketentuan yang berlaku. Kitelay adalah platform manajemen kompetisi digital yang memfasilitasi pendaftaran, pengumpulan karya, dan penilaian lomba antar sekolah.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900">2. Akun & Keamanan Data</h2>
                <ul class="mt-3 list-disc pl-5 space-y-2">
                    <li>Peserta wajib menggunakan data diri asli (Nama, NIS, dan Asal Sekolah) saat melakukan pendaftaran akun.</li>
                    <li>Pengguna bertanggung jawab penuh untuk menjaga kerahasiaan kata sandi (password) masing-masing.</li>
                    <li>Pihak panitia berhak menonaktifkan akun yang terindikasi menggunakan data palsu atau melakukan aktivitas mencurigakan.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900">3. Peran & Tanggung Jawab</h2>
                <ul class="mt-3 list-disc pl-5 space-y-2">
                    <li><strong class="text-slate-800">Peserta:</strong> Bertanggung jawab untuk mengirimkan karya submission sesuai dengan tenggat waktu (deadline) dan kriteria yang telah ditentukan di masing-masing lomba.</li>
                    <li><strong class="text-slate-800">Juri:</strong> Diwajibkan memberikan penilaian secara objektif, jujur, dan berdasarkan format kriteria berbobot yang ada di dalam sistem Kitelay.</li>
                    <li><strong class="text-slate-800">Admin:</strong> Berhak mengelola jalannya perlombaan, termasuk mendiskualifikasi peserta yang melanggar aturan.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900">4. Sistem Penilaian & Keputusan</h2>
                <p class="mt-3">
                    Nilai akhir yang ditampilkan pada fitur <em>Leaderboard</em> (Ranking) dan Podium merupakan akumulasi otomatis dari penilaian para juri. <strong>Keputusan juri dan panitia penyelenggara bersifat mutlak dan tidak dapat diganggu gugat.</strong>
                </p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900">5. Pelanggaran & Sanksi</h2>
                <p class="mt-3">
                    Segala bentuk kecurangan, termasuk namun tidak terbatas pada plagiarisme karya, manipulasi data, atau upaya peretasan sistem akan berakibat pada pendiskualifikasian peserta secara sepihak oleh panitia.
                </p>
            </div>

        </div>
    </div>
</section>
@endsection