<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 relative z-10">
            <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">sports_esports</span>
                <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Peserta Dashboard</span>
            </div>
            
            <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl drop-shadow-md">
                Katalog <span class="text-amber-400">Lomba</span>
            </h2>
            <p class="max-w-2xl text-sm font-medium leading-7 text-slate-400 sm:text-base">
                Pilih perlombaan yang ingin kamu ikuti, lengkapi submission-mu, dan pantau hasil akhir dari satu pusat kendali.
            </p>
        </div>
    </x-slot>

    @php
        $registeredCount = $myRegistrations->count();
        $submittedCount = $myRegistrations->whereIn('status', [\App\Models\Pendaftaran::STATUS_SUBMITTED, \App\Models\Pendaftaran::STATUS_REVIEWED])->count();
        $reviewedCount = $myRegistrations->where('status', \App\Models\Pendaftaran::STATUS_REVIEWED)->count();
        $visibleResultsCount = $myRegistrations->filter(fn ($registration) => $registration->status === \App\Models\Pendaftaran::STATUS_REVIEWED && $registration->perlombaan->resultsAreVisible())->count();
    @endphp

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 100)">
        
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-amber-500/5 rounded-full blur-[120px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10">
            
            <section class="rounded-tl-[3rem] rounded-br-[3rem] rounded-tr-md rounded-bl-md border border-red-900/50 bg-gradient-to-br from-[#0a0a0c] to-[#050505] p-8 sm:p-10 shadow-[0_0_30px_rgba(220,38,38,0.15)] relative overflow-hidden transition-all duration-700 ease-out"
                     :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-red-600 to-amber-400"></div>
                
                <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <p class="text-[12px] font-black uppercase tracking-widest text-amber-500 mb-2">Lomba Tersedia</p>
                        <h3 class="text-2xl font-black uppercase tracking-wide text-white sm:text-3xl">Pilih arena bertandingmu.</h3>
                        <p class="mt-4 text-[14px] font-medium leading-relaxed text-slate-400 max-w-xl">
                            Setelah mendaftar, kamu bisa langsung melengkapi dokumen submission, mengunggah karya, dan memantau status penilaian dewan juri.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="rounded-xl border border-neutral-800 bg-black/50 p-4 backdrop-blur transition-colors hover:border-red-500/50 group">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-amber-400 transition-colors">Tersedia</p>
                            <p class="mt-2 text-3xl font-black tabular-nums text-white drop-shadow-md">{{ $availableCompetitions->count() }}</p>
                        </div>
                        <div class="rounded-xl border border-neutral-800 bg-black/50 p-4 backdrop-blur transition-colors hover:border-red-500/50 group">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-amber-400 transition-colors">Diikuti</p>
                            <p class="mt-2 text-3xl font-black tabular-nums text-white drop-shadow-md">{{ $registeredCount }}</p>
                        </div>
                        <div class="rounded-xl border border-neutral-800 bg-black/50 p-4 backdrop-blur transition-colors hover:border-red-500/50 group">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-amber-400 transition-colors">Dinilai</p>
                            <p class="mt-2 text-3xl font-black tabular-nums text-white drop-shadow-md">{{ $reviewedCount }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-3 transition-all duration-700 delay-100 ease-out"
                     :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <article class="tilt-card rounded-tl-2xl rounded-br-2xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-6 shadow-lg transition-all hover:border-amber-500/50 group relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-600 group-hover:bg-amber-400 transition-colors"></div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-slate-500">Pendaftaran Saya</p>
                    <p class="mt-3 text-4xl font-black tabular-nums text-white group-hover:text-amber-400 transition-colors">{{ $registeredCount }}</p>
                    <p class="mt-3 text-[13px] font-medium leading-relaxed text-slate-400">Total perlombaan yang kamu ikuti musim ini.</p>
                </article>
                
                <article class="tilt-card rounded-tl-2xl rounded-br-2xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-6 shadow-lg transition-all hover:border-amber-500/50 group relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-600 group-hover:bg-amber-400 transition-colors"></div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-slate-500">Submission Masuk</p>
                    <p class="mt-3 text-4xl font-black tabular-nums text-amber-500 drop-shadow-[0_0_10px_rgba(245,158,11,0.3)]">{{ $submittedCount }}</p>
                    <p class="mt-3 text-[13px] font-medium leading-relaxed text-slate-400">Karya yang menunggu hasil evaluasi dewan juri.</p>
                </article>

                <article class="tilt-card rounded-tl-2xl rounded-br-2xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-6 shadow-lg transition-all hover:border-amber-500/50 group relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-600 group-hover:bg-amber-400 transition-colors"></div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-slate-500">Hasil Tersedia</p>
                    <p class="mt-3 text-4xl font-black tabular-nums text-red-500 drop-shadow-[0_0_10px_rgba(239,68,68,0.3)]">{{ $visibleResultsCount }}</p>
                    <p class="mt-3 text-[13px] font-medium leading-relaxed text-slate-400">Pengumuman podium yang telah dibuka resmi.</p>
                </article>
            </section>

            <section class="mt-8 transition-all duration-700 delay-200 ease-out"
                     :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between border-b border-red-900/30 pb-4">
                    <div>
                        <p class="text-[12px] font-black uppercase tracking-widest text-amber-500">Eksplorasi</p>
                        <h3 class="mt-2 text-2xl font-black uppercase tracking-wide text-white sm:text-3xl">Lomba Terbuka.</h3>
                    </div>
                    <p class="max-w-xl text-[14px] font-medium leading-relaxed text-slate-400">Buka detail lomba terlebih dahulu untuk membaca rundown, kriteria, dan jadwal penting sebelum bertanding.</p>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
                    @forelse ($availableCompetitions as $competition)
                        <article class="tilt-card flex flex-col rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#050505] p-6 shadow-xl transition-all hover:border-amber-500/50 group relative">
                            
                            <div class="flex items-start justify-between gap-4">
                                <span class="inline-flex px-3 py-1.5 text-[10px] font-black uppercase tracking-widest shadow-md bg-gradient-to-r from-red-900/60 to-black text-amber-400 border-l-2 border-amber-400 skew-x-[-10deg]">
                                    <span class="skew-x-[10deg]">{{ str($competition->status)->replace('_', ' ')->title() }}</span>
                                </span>
                                <span class="text-[11px] font-bold tracking-widest text-slate-500 pt-1">
                                    {{ optional($competition->registration_end_at)->translatedFormat('d M Y') ?? optional($competition->deadline_pendaftaran)->translatedFormat('d M Y') ?? '-' }}
                                </span>
                            </div>

                            <h3 class="mt-6 text-xl font-black uppercase tracking-wide text-white group-hover:text-amber-400 transition-colors leading-snug">{{ $competition->nama_lomba }}</h3>
                            <p class="mt-3 text-[13px] font-medium leading-relaxed text-slate-400 line-clamp-2">{{ \Illuminate\Support\Str::limit($competition->deskripsi, 140) }}</p>

                            <div class="mt-auto pt-6">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="rounded-xl bg-[#0a0a0c] p-3 text-center border border-neutral-800 transition-colors group-hover:border-amber-900/50">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Kriteria</p>
                                        <p class="mt-1 text-lg font-black text-white group-hover:text-amber-400">{{ $competition->kriterias_count }}</p>
                                    </div>
                                    <div class="rounded-xl bg-[#0a0a0c] p-3 text-center border border-neutral-800 transition-colors group-hover:border-amber-900/50">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Juri</p>
                                        <p class="mt-1 text-lg font-black text-white group-hover:text-amber-400">{{ $competition->juris_count }}</p>
                                    </div>
                                    <div class="rounded-xl bg-[#0a0a0c] p-3 text-center border border-neutral-800 transition-colors group-hover:border-amber-900/50">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Peserta</p>
                                        <p class="mt-1 text-lg font-black text-white group-hover:text-amber-400">{{ $competition->pendaftarans_count }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-4 border-t border-neutral-800 pt-5 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Deadline Daftar</p>
                                    <p class="mt-1 text-[13px] font-bold text-red-400">{{ optional($competition->registration_end_at)->translatedFormat('d M Y') ?? optional($competition->deadline_pendaftaran)->translatedFormat('d M Y') ?? '-' }}</p>
                                </div>

                                <div class="flex flex-col items-start gap-3 sm:items-end">
                                    @if (in_array($competition->id, $registeredCompetitionIds, true))
                                        <span class="inline-flex rounded-sm bg-red-900/30 px-3 py-1.5 text-[11px] font-black uppercase tracking-widest text-red-400 border border-red-500/30 skew-x-[-10deg]">
                                            <span class="skew-x-[10deg]">Sudah Terdaftar</span>
                                        </span>
                                    @endif

                                    <a href="{{ route('peserta.lomba.show', $competition) }}" class="inline-flex items-center justify-center rounded-sm bg-red-600 px-6 py-2.5 text-[11px] font-black uppercase tracking-widest text-white transition-all hover:bg-red-700 shadow-[0_0_15px_rgba(220,38,38,0.2)] hover:shadow-[0_0_25px_rgba(251,191,36,0.4)] border border-transparent hover:border-amber-400 skew-x-[-10deg]">
                                        <span class="skew-x-[10deg]">{{ in_array($competition->id, $registeredCompetitionIds, true) ? 'Lihat Detail' : 'Detail & Rundown' }}</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-dashed border-neutral-700 bg-[#050505] p-12 text-center text-[12px] font-black uppercase tracking-widest text-slate-500 lg:col-span-2 xl:col-span-3">
                            <span class="material-symbols-outlined mb-3 text-4xl block text-slate-600">inbox</span>
                            Belum ada lomba yang tersedia untuk peserta.
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="mt-8 transition-all duration-700 delay-300 ease-out"
                     :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between border-b border-neutral-800 pb-4">
                    <div>
                        <p class="text-[12px] font-black uppercase tracking-widest text-amber-500">Lomba Saya</p>
                        <h3 class="mt-2 text-2xl font-black uppercase tracking-wide text-white sm:text-3xl">Riwayat Pendaftaran.</h3>
                    </div>
                    <p class="max-w-xl text-[14px] font-medium leading-relaxed text-slate-400">Dari sini kamu bisa cek status, lengkapi submission, dan melihat hasil setelah diumumkan.</p>
                </div>

                <div class="mt-6 overflow-hidden rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] shadow-2xl relative">
                    
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-600 via-amber-500 to-red-900"></div>

                    <div class="px-6 py-5 border-b border-neutral-800 bg-[#050505] flex items-center gap-3">
                        <span class="material-symbols-outlined text-amber-500">app_registration</span>
                        <h3 class="text-[12px] font-black uppercase tracking-widest text-white">Status Penilaian & Aksi</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-800 text-sm">
                            <thead class="bg-[#0a0a0c] text-left text-[10px] font-black uppercase tracking-widest text-amber-500 border-b border-neutral-700 shadow-sm">
                                <tr>
                                    <th class="px-6 py-5">Perlombaan</th>
                                    <th class="px-6 py-5">Status</th>
                                    <th class="px-6 py-5">Submission Masuk</th>
                                    <th class="px-6 py-5">Nilai Akhir</th>
                                    <th class="px-6 py-5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-800 bg-[#0a0a0c]">
                                @forelse ($myRegistrations as $registration)
                                    <tr class="tilt-row transition-colors hover:bg-[#050505]">
                                        <td class="px-6 py-6 align-top">
                                            <p class="text-[15px] font-black uppercase tracking-wide text-white">{{ $registration->perlombaan->nama_lomba }}</p>
                                            <p class="mt-2 text-[13px] font-medium leading-relaxed text-slate-400">{{ $registration->submission_title ?: 'Belum ada submission' }}</p>
                                        </td>
                                        
                                        <td class="px-6 py-6 align-top">
                                            <span class="inline-flex px-3 py-1.5 text-[9px] font-black uppercase tracking-widest bg-gradient-to-r from-red-900/60 to-black text-amber-400 border-l-2 border-amber-400 skew-x-[-10deg]">
                                                <span class="skew-x-[10deg]">{{ str($registration->status)->replace('_', ' ')->title() }}</span>
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-6 align-top text-[13px] font-bold tracking-widest text-slate-400 uppercase">
                                            {{ $registration->submitted_at?->translatedFormat('d M Y H:i') ?? 'Belum submit' }}
                                        </td>
                                        
                                        <td class="px-6 py-6 align-top text-lg font-black tabular-nums text-white">
                                            @if ($registration->final_score !== null && $registration->perlombaan->resultsAreVisible())
                                                <span class="text-emerald-400 drop-shadow-md">{{ number_format((float) $registration->final_score, 2) }}</span>
                                            @elseif ($registration->final_score !== null)
                                                <span class="text-[11px] font-black uppercase tracking-widest text-amber-500">Menunggu Publikasi</span>
                                            @else
                                                <span class="text-slate-600">-</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-6 align-top">
                                            <div class="flex justify-end gap-3 flex-wrap">
                                                @if ($registration->final_score !== null && $registration->perlombaan->resultsAreVisible())
                                                    <a href="{{ route('peserta.lomba.results', $registration) }}" class="inline-flex items-center justify-center rounded-sm bg-gradient-to-r from-amber-500 to-orange-600 px-5 py-2.5 text-[11px] font-black uppercase tracking-widest text-black transition-all hover:scale-105 shadow-[0_0_15px_rgba(245,158,11,0.3)] skew-x-[-10deg]">
                                                        <span class="skew-x-[10deg]">Lihat Hasil</span>
                                                    </a>
                                                @elseif ($registration->final_score !== null)
                                                    <span class="inline-flex items-center justify-center rounded-sm border border-amber-600/30 bg-amber-900/20 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-amber-500 skew-x-[-10deg]">
                                                        <span class="skew-x-[10deg]">Dalam Proses Penilaian</span>
                                                    </span>
                                                @endif
                                                
                                                <a href="{{ route('peserta.lomba.edit', $registration) }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-black px-5 py-2.5 text-[11px] font-black uppercase tracking-widest text-slate-300 transition-all hover:border-amber-400 hover:text-amber-400 skew-x-[-10deg]">
                                                    <span class="skew-x-[10deg]">{{ $registration->submitted_at ? 'Edit Karya' : 'Isi Karya' }}</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center">
                                            <span class="material-symbols-outlined text-4xl text-slate-700 mb-3 block">search_off</span>
                                            <p class="text-[12px] font-black uppercase tracking-widest text-slate-500">Kamu belum mendaftar ke arena mana pun.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiltElements = document.querySelectorAll('.tilt-card, .tilt-row');
            
            tiltElements.forEach(el => {
                el.style.transformStyle = 'preserve-3d';
                
                el.addEventListener('mouseenter', () => {
                    el.style.transition = 'transform 0.1s ease-out, box-shadow 0.1s ease-out';
                    el.style.zIndex = "50"; 
                });

                el.addEventListener('mousemove', (e) => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = ((y - centerY) / centerY) * -12; 
                    const rotateY = ((x - centerX) / centerX) * 12;
                    const scale = el.classList.contains('tilt-row') ? 1.02 : 1.05;
                    
                    el.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(${scale})`;

                    const shadowX = ((x - centerX) / centerX) * -20;
                    const shadowY = ((y - centerY) / centerY) * -20;
                    
                    // Glow warna Merah-Keemasan
                    el.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(251, 191, 36, 0.15), 0 0 15px rgba(220, 38, 38, 0.2)`;
                });

                el.addEventListener('mouseleave', () => {
                    el.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.6s ease-out';
                    el.style.transform = `perspective(800px) rotateX(0deg) rotateY(0deg) scale(1)`;
                    el.style.boxShadow = '';
                    el.style.zIndex = "1";
                });
            });
        });
    </script>
</x-app-layout>