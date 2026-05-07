<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-400">Juri Workspace</p>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-black tracking-[-0.04em] text-white">Hasil & Podium Lomba</h2>
                <p class="mt-1 text-sm text-slate-300">{{ $perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('juri.penilaian.submissions', $perlombaan) }}" class="inline-flex items-center justify-center rounded-2xl border border-neutral-700 bg-[#0a0a0c] px-5 py-3 text-sm font-bold text-white transition hover:border-amber-400">
                Kembali ke Submission
            </a>
        </div>
    </x-slot>

    <div class="bg-black py-6 md:py-10" x-data>
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 md:px-6 lg:px-8">
            
            <x-page-hero eyebrow="Hasil Akhir" title="Podium dan ranking final." description="Halaman ini bersifat baca saja untuk memantau hasil akhir." accent="orange">
                <div class="flex flex-wrap gap-3">
                    <a href="#podium" class="inline-flex items-center justify-center rounded-2xl bg-red-700 px-5 py-3 text-sm font-bold text-white hover:bg-red-600 transition-all shadow-[0_0_30px_rgba(220,38,38,0.6)]">Lihat Podium</a>
                </div>
            </x-page-hero>

            <section id="podium" class="rounded-[2rem] border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl">
                <h3 class="text-2xl font-black text-white mb-8 uppercase tracking-widest">Podium Utama</h3>
                <div class="grid gap-6 md:gap-8 lg:grid-cols-3">
                    @foreach ($podium as $participant)
                        @php
                            $colors = [
                                1 => 'border-amber-400 bg-gradient-to-br from-amber-600/30 via-black to-black shadow-[0_0_60px_rgba(251,191,36,0.3)]',
                                2 => 'border-slate-400 bg-gradient-to-br from-slate-600/30 via-black to-black shadow-[0_0_60px_rgba(156,163,175,0.3)]',
                                3 => 'border-orange-700 bg-gradient-to-br from-orange-900/40 via-black to-black shadow-[0_0_60px_rgba(194,65,12,0.3)]'
                            ];
                            $activeClass = $colors[$loop->iteration] ?? 'border-neutral-800 bg-[#050505]';
                        @endphp

                        <article class="tilt-card group relative overflow-hidden rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border-2 p-6 transition-all duration-300 transform-gpu {{ $activeClass }} hover:scale-[1.03]">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.16),transparent_32%)] opacity-70 pointer-events-none"></div>
                            <div class="absolute -right-10 -top-10 h-24 w-24 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-white/40"></div>
                            <p data-tilt-layer="16" class="mb-4 text-[11px] font-black uppercase tracking-widest text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.8)]">
                                Juara {{ $participant->ranking_position }}
                            </p>
                            <h4 data-tilt-layer="26" class="text-3xl font-black text-white drop-shadow-md">{{ $participant->user->name }}</h4>
                            <p data-tilt-layer="12" class="mt-2 text-sm font-bold text-slate-200">{{ $participant->submission_title }}</p>
                            <div data-tilt-layer="22" class="mt-6 rounded-xl border border-white/10 bg-black/50 p-4 backdrop-blur-sm">
                                <p class="text-[10px] font-black uppercase text-slate-400">Skor Final</p>
                                <p class="text-4xl font-black text-white">{{ number_format((float) $participant->final_score, 2) }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section id="ranking" class="overflow-hidden rounded-[2rem] border border-neutral-800 bg-[#0a0a0c] shadow-2xl">
                <div class="p-6 border-b border-neutral-800">
                    <h3 class="text-xl font-black text-white">Daftar Ranking Lengkap</h3>
                </div>
                <div class="space-y-4 p-4 md:hidden">
                    @foreach ($rankedRegistrations as $registration)
                        @php
                            $cardHighlight = '';
                            if ($registration->ranking_position == 1) $cardHighlight = 'border-amber-400 bg-gradient-to-r from-amber-500/20 to-transparent shadow-[0_0_30px_rgba(251,191,36,0.12)]';
                            elseif ($registration->ranking_position == 2) $cardHighlight = 'border-slate-300 bg-gradient-to-r from-slate-400/20 to-transparent shadow-[0_0_30px_rgba(156,163,175,0.12)]';
                            elseif ($registration->ranking_position == 3) $cardHighlight = 'border-orange-500 bg-gradient-to-r from-orange-700/20 to-transparent shadow-[0_0_30px_rgba(194,65,12,0.12)]';
                            else $cardHighlight = 'border-neutral-800 bg-[#050505]';
                        @endphp

                        <article class="tilt-card group relative overflow-hidden rounded-tl-[1.5rem] rounded-br-[1.5rem] rounded-tr-sm rounded-bl-sm border p-5 transition-all duration-300 transform-gpu {{ $cardHighlight }}">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.12),transparent_35%)] pointer-events-none"></div>
                            <div class="absolute top-0 left-0 h-full w-1 bg-gradient-to-b from-white/30 via-white/10 to-transparent pointer-events-none"></div>
                            <div class="flex items-start justify-between gap-4">
                                <div data-tilt-layer="20" class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg font-black text-white">#{{ $registration->ranking_position }}</span>
                                        @if($registration->ranking_position <= 3)
                                            <span data-tilt-layer="26" class="inline-flex shrink-0 whitespace-nowrap rounded-full px-2 py-0.5 text-[10px] font-black uppercase {{ $registration->ranking_position == 1 ? 'bg-amber-400 text-black' : ($registration->ranking_position == 2 ? 'bg-slate-300 text-black' : 'bg-orange-500 text-white') }}">Top {{ $registration->ranking_position }}</span>
                                        @endif
                                    </div>
                                    <p class="mt-3 truncate text-[15px] font-black text-white">{{ $registration->user->name }}</p>
                                    <p class="mt-1 text-[12px] font-medium text-slate-300">{{ $registration->submission_title }}</p>
                                </div>
                                <div data-tilt-layer="24" class="shrink-0 rounded-xl border border-white/10 bg-black/40 px-3 py-2 text-right backdrop-blur-sm">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Nilai</p>
                                    <p class="mt-1 text-2xl font-black text-amber-400">{{ number_format((float) $registration->final_score, 2) }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-[640px] w-full divide-y divide-neutral-800">
                        <tbody class="divide-y divide-neutral-800">
                            @foreach ($rankedRegistrations as $registration)
                                @php
                                    $rowHighlight = '';
                                    if ($registration->ranking_position == 1) $rowHighlight = 'bg-gradient-to-r from-amber-500/20 to-transparent border-l-4 border-amber-400 shadow-[inset_10px_0_20px_-10px_rgba(251,191,36,0.5)]';
                                    elseif ($registration->ranking_position == 2) $rowHighlight = 'bg-gradient-to-r from-slate-400/20 to-transparent border-l-4 border-slate-300 shadow-[inset_10px_0_20px_-10px_rgba(156,163,175,0.5)]';
                                    elseif ($registration->ranking_position == 3) $rowHighlight = 'bg-gradient-to-r from-orange-700/20 to-transparent border-l-4 border-orange-500 shadow-[inset_10px_0_20px_-10px_rgba(194,65,12,0.5)]';
                                @endphp
                                <tr class="tilt-row group transition-all hover:bg-neutral-900/80 {{ $rowHighlight }}">
                                    <td class="px-6 py-5 font-black text-white transition-all">#{{ $registration->ranking_position }}</td>
                                    <td class="px-6 py-5 font-bold text-white">
                                        <div class="flex items-center gap-2 min-w-[150px]">
                                            <span class="truncate">{{ $registration->user->name }}</span>
                                        @if($registration->ranking_position <= 3)
                                                <span class="inline-flex shrink-0 whitespace-nowrap text-[10px] font-black uppercase px-2 py-0.5 rounded-full {{ $registration->ranking_position == 1 ? 'bg-amber-400 text-black' : ($registration->ranking_position == 2 ? 'bg-slate-300 text-black' : 'bg-orange-500 text-white') }}">Top {{ $registration->ranking_position }}</span>
                                        @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-slate-200 font-medium">{{ $registration->submission_title }}</td>
                                    <td class="px-6 py-5 font-black text-amber-400 text-lg">{{ number_format((float) $registration->final_score, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tilt-card, .tilt-row').forEach(el => {
            const layers = el.querySelectorAll('[data-tilt-layer]');
            el.style.transformStyle = 'preserve-3d';

            el.addEventListener('mouseenter', () => {
                el.style.transition = 'transform 0.12s ease-out, box-shadow 0.12s ease-out';
                el.style.zIndex = '20';
            });

            el.addEventListener('mousemove', (e) => {
                const rect = el.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = ((y - centerY) / centerY) * -10;
                const rotateY = ((x - centerX) / centerX) * 10;
                const scale = el.classList.contains('tilt-row') ? 1.015 : 1.04;
                const shadowX = ((x - centerX) / centerX) * -18;
                const shadowY = ((y - centerY) / centerY) * -18;

                el.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(${scale})`;
                el.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(251, 191, 36, 0.18), 0 0 22px rgba(220, 38, 38, 0.18)`;

                layers.forEach(layer => {
                    const depth = Number(layer.dataset.tiltLayer || 0);
                    const offsetX = ((x - centerX) / centerX) * (depth / 14);
                    const offsetY = ((y - centerY) / centerY) * (depth / 14);
                    layer.style.transform = `translate3d(${offsetX}px, ${offsetY}px, ${depth}px)`;
                });
            });

            el.addEventListener('mouseleave', () => {
                el.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.6s ease-out';
                el.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg) scale(1)';
                el.style.boxShadow = '';
                el.style.zIndex = '1';

                layers.forEach(layer => {
                    layer.style.transform = '';
                });
            });
        });
    </script>
</x-app-layout>
