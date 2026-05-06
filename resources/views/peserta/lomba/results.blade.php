<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between relative z-10">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-emerald-400 bg-gradient-to-r from-emerald-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                    <span class="material-symbols-outlined text-[16px] text-emerald-400">emoji_events</span>
                    <span class="text-[11px] font-black uppercase tracking-widest text-emerald-400">Peserta Dashboard</span>
                </div>
                
                <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl drop-shadow-md">
                    Hasil <span class="text-emerald-400">Lomba</span>
                </h2>
                <p class="text-sm font-medium text-slate-400">{{ $pendaftaran->perlombaan->nama_lomba }}</p>
            </div>

            <a href="{{ route('peserta.lomba.index') }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-transparent px-6 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-500 hover:text-white transition-all skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Kembali ke Arena</span>
            </a>
        </div>
    </x-slot>

    @php
        $isOnPodium = $myRanking && $myRanking->ranking_position <= 3;
    @endphp

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-amber-600/5 rounded-full blur-[120px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <section class="tilt-card rounded-tl-[3rem] rounded-br-[3rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-emerald-400 to-emerald-700"></div>
                
                <div class="max-w-3xl">
                    <p class="text-[11px] font-black uppercase tracking-widest text-emerald-500">Ringkasan Hasil</p>
                    <h3 class="mt-2 text-3xl font-black uppercase tracking-wide text-white">Nilai akhir dan posisimu.</h3>
                    <p class="mt-3 text-[14px] leading-relaxed text-slate-400">Halaman ini merangkum nilai finalmu, podium juara, dan ranking lengkap peserta yang sudah diumumkan.</p>
                </div>

                <div class="mt-6 flex flex-wrap gap-4">
                    <a href="#podium" class="inline-flex items-center justify-center rounded-sm bg-gradient-to-r from-emerald-600 to-emerald-800 px-6 py-3 text-[11px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:scale-105 transition-all skew-x-[-10deg]">
                        <span class="skew-x-[10deg]">Lihat Podium</span>
                    </a>
                    <a href="#ranking" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-black px-6 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:text-white hover:border-slate-500 transition-all skew-x-[-10deg]">
                        <span class="skew-x-[10deg]">Ranking Lengkap</span>
                    </a>
                </div>

                <div class="mt-8 rounded-xl border border-neutral-800 bg-[#050505] p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $isOnPodium ? 'bg-amber-400' : 'bg-emerald-400' }} opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 {{ $isOnPodium ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                        </span>
                        <p class="text-[10px] font-black uppercase tracking-widest {{ $isOnPodium ? 'text-amber-500' : 'text-emerald-500' }}">Status Hasil</p>
                    </div>
                    <p class="text-[13px] font-medium leading-relaxed text-slate-300">
                        {{ $isOnPodium ? 'Selamat, kamu sedang ada di zona podium! Cek kartu juara di bawah untuk melihat posisi finalmu.' : 'Hasil sudah resmi dibuka. Kamu bisa cek podium di bawah dan lihat posisimu di ranking lengkap.' }}
                    </p>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-xl border border-neutral-800 bg-[#050505] p-5 text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Nama Peserta</p>
                        <p class="mt-2 text-lg font-black uppercase tracking-wide text-white">{{ $pendaftaran->user->name }}</p>
                    </div>
                    <div class="rounded-xl border border-neutral-800 bg-[#050505] p-5 text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Nilai Akhir</p>
                        <p class="mt-2 text-3xl font-black text-emerald-400 drop-shadow-[0_0_8px_rgba(52,211,153,0.5)]">
                            {{ $pendaftaran->final_score !== null ? number_format((float) $pendaftaran->final_score, 2) : '-' }}
                        </p>
                    </div>
                    <div class="rounded-xl border border-neutral-800 bg-[#050505] p-5 text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Posisi</p>
                        <p class="mt-2 text-3xl font-black {{ $isOnPodium ? 'text-amber-400 drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]' : 'text-white' }}">
                            {{ $myRanking ? '#'.$myRanking->ranking_position : '-' }}
                        </p>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 md:grid-cols-3">
                <article class="tilt-card rounded-xl border border-neutral-800 bg-[#0a0a0c] p-6 shadow-xl hover:border-neutral-700 transition-all">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Jumlah Peserta Diranking</p>
                    <p class="mt-2 text-4xl font-black text-white">{{ $rankedRegistrations->count() }}</p>
                </article>
                <article class="tilt-card rounded-xl border {{ $isOnPodium ? 'border-amber-900/50 bg-amber-900/10' : ($pendaftaran->final_score !== null ? 'border-emerald-900/50 bg-emerald-900/10' : 'border-neutral-800 bg-[#0a0a0c]') }} p-6 shadow-xl transition-all">
                    <p class="text-[10px] font-black uppercase tracking-widest {{ $isOnPodium ? 'text-amber-500' : ($pendaftaran->final_score !== null ? 'text-emerald-500' : 'text-slate-500') }}">Status Kamu</p>
                    <p class="mt-2 text-2xl font-black uppercase {{ $isOnPodium ? 'text-amber-400' : ($pendaftaran->final_score !== null ? 'text-emerald-400' : 'text-slate-400') }}">
                        {{ $isOnPodium ? 'Masuk Podium!' : ($pendaftaran->final_score !== null ? 'Selesai Dinilai' : 'Menunggu') }}
                    </p>
                </article>
                <article class="tilt-card rounded-xl border border-amber-900/30 bg-[#0a0a0c] p-6 shadow-xl hover:border-amber-500/30 transition-all">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Podium Tersedia</p>
                    <p class="mt-2 text-4xl font-black text-amber-500">{{ $podium->count() }}</p>
                </article>
            </section>

            <section id="podium" class="rounded-[2rem] border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl relative overflow-hidden">
                <div class="mb-8 border-b border-neutral-800 pb-6">
                    <p class="text-[11px] font-black uppercase tracking-widest text-amber-500">Hall of Fame</p>
                    <h3 class="mt-2 text-2xl font-black uppercase tracking-wide text-white">Top 3 Podium</h3>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    @forelse ($podium as $participant)
                        @php
                            // Logika Warna Podium
                            $podiumStyle = '';
                            $badgeText = '';
                            if ($loop->iteration === 1) {
                                $podiumStyle = 'border-amber-400 bg-amber-900/10 shadow-[0_0_20px_rgba(251,191,36,0.15)]'; // Gold
                                $badgeText = 'text-amber-400';
                            } elseif ($loop->iteration === 2) {
                                $podiumStyle = 'border-slate-400 bg-slate-900/30'; // Silver
                                $badgeText = 'text-slate-300';
                            } else {
                                $podiumStyle = 'border-orange-600 bg-orange-900/10'; // Bronze
                                $badgeText = 'text-orange-500';
                            }

                            // Highlight jika ini user yang sedang login
                            $isMe = $participant->id === $pendaftaran->id;
                            if ($isMe) {
                                $podiumStyle .= ' ring-2 ring-emerald-500 ring-offset-4 ring-offset-[#0a0a0c]';
                            }
                        @endphp

                        <article class="tilt-card rounded-[2rem] border p-8 {{ $podiumStyle }} relative overflow-hidden flex flex-col justify-between">
                            @if($loop->iteration === 1) <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-500/20 blur-[30px] rounded-full"></div> @endif
                            
                            <div>
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-[12px] font-black uppercase tracking-widest {{ $badgeText }}">
                                            Juara {{ $participant->ranking_position }}
                                        </p>
                                        @if ($isMe)
                                            <span class="mt-2 inline-block px-2 py-1 text-[9px] font-black uppercase tracking-widest bg-emerald-900/40 text-emerald-400 border border-emerald-500/30 skew-x-[-10deg]">
                                                <span class="skew-x-[10deg]">Ini Posisimu</span>
                                            </span>
                                        @endif
                                    </div>
                                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-black border border-neutral-700 text-2xl font-black {{ $badgeText }}">
                                        {{ $participant->ranking_position }}
                                    </span>
                                </div>
                                <h4 class="mt-6 text-2xl font-black uppercase tracking-wide text-white">{{ $participant->user->name }}</h4>
                                <p class="mt-2 text-[12px] font-medium text-slate-500 line-clamp-2">{{ $participant->submission_title ?: 'Belum ada judul' }}</p>
                            </div>
                            
                            <div class="mt-8 rounded-xl border border-neutral-800 bg-black/50 p-5 text-center backdrop-blur-sm">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Skor Final</p>
                                <p class="mt-1 text-4xl font-black text-white">{{ number_format((float) $participant->final_score, 2) }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-3 rounded-2xl border border-dashed border-neutral-800 bg-[#050505] p-12 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-700 mb-3 block">workspace_premium</span>
                            <p class="text-[12px] font-black uppercase tracking-widest text-slate-500">Podium belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <section id="ranking" class="overflow-hidden rounded-[2rem] border border-neutral-800 bg-[#0a0a0c] shadow-2xl">
                <div class="border-b border-neutral-800 bg-[#050505] px-8 py-6">
                    <p class="text-[11px] font-black uppercase tracking-widest text-sky-500">Papan Skor Klasemen</p>
                    <h3 class="mt-2 text-2xl font-black uppercase tracking-wide text-white">Ranking Lengkap Peserta</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-800 text-sm">
                        <thead class="bg-[#050505] text-left text-[10px] font-black uppercase tracking-widest text-slate-500">
                            <tr>
                                <th class="px-8 py-5">Rank</th>
                                <th class="px-8 py-5">Peserta</th>
                                <th class="px-8 py-5">Karya / Submission</th>
                                <th class="px-8 py-5 text-right">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800 bg-[#0a0a0c]">
                            @forelse ($rankedRegistrations as $registration)
                                @php
                                    $isMe = $registration->id === $pendaftaran->id;
                                @endphp
                                <tr class="tilt-row transition-colors hover:bg-[#050505] {{ $isMe ? 'bg-emerald-900/10 border-l-4 border-emerald-500' : '' }}">
                                    <td class="px-8 py-6 align-middle text-xl font-black text-slate-400">
                                        #{{ $registration->ranking_position }}
                                    </td>
                                    
                                    <td class="px-8 py-6 align-middle">
                                        <div class="flex items-center gap-3">
                                            <p class="text-[15px] font-black uppercase tracking-wide {{ $isMe ? 'text-emerald-400' : 'text-white' }}">
                                                {{ $registration->user->name }}
                                            </p>
                                            @if ($isMe)
                                                <span class="inline-block px-2 py-1 text-[9px] font-black uppercase tracking-widest bg-emerald-900/40 text-emerald-400 skew-x-[-10deg]">
                                                    <span class="skew-x-[10deg]">Kamu</span>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="px-8 py-6 align-middle text-[12px] font-medium text-slate-500">
                                        {{ $registration->submission_title ?: 'Belum ada judul' }}
                                    </td>
                                    
                                    <td class="px-8 py-6 align-middle text-right text-xl font-black text-white">
                                        {{ number_format((float) $registration->final_score, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center text-[12px] font-black uppercase tracking-widest text-slate-600">
                                        Belum ada ranking yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tiltElements = document.querySelectorAll('.tilt-card, .tilt-row');
        
        tiltElements.forEach(el => {
            // Setup awal
            el.style.transformStyle = 'preserve-3d';
            
            el.addEventListener('mouseenter', () => {
                // Transisi cepat saat mouse masuk
                el.style.transition = 'transform 0.1s ease-out, box-shadow 0.1s ease-out';
                el.style.zIndex = "50"; // Bawa kartu ke paling depan saat disorot
            });

            el.addEventListener('mousemove', (e) => {
                const rect = el.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                // 1. ROTASI EKSTREM (Maksimal 10-12 derajat)
                const rotateX = ((y - centerY) / centerY) * -12; 
                const rotateY = ((x - centerX) / centerX) * 12;
                
                // 2. ZOOM LEBIH BESAR
                const scale = el.classList.contains('tilt-row') ? 1.02 : 1.05;
                
                // Terapkan Transformasi dengan Perspektif Dekat (800px)
                el.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(${scale})`;

                // 3. SHADOW/GLOW DINAMIS BERLAWANAN ARAH MOUSE
                const shadowX = ((x - centerX) / centerX) * -20;
                const shadowY = ((y - centerY) / centerY) * -20;
                
                // Warna glow (kuning keemasan / amber)
                el.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(251, 191, 36, 0.2), 0 0 15px rgba(220, 38, 38, 0.3)`;
            });

            el.addEventListener('mouseleave', () => {
                // Transisi lambat dan mulus saat mouse keluar (kembali ke asal)
                el.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.6s ease-out';
                el.style.transform = `perspective(800px) rotateX(0deg) rotateY(0deg) scale(1)`;
                el.style.boxShadow = ''; // Hapus shadow dinamis
                el.style.zIndex = "1"; // Kembalikan index
            });
        });
    });
</script>
</x-app-layout>