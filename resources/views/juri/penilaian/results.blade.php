<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.28em] text-sky-400">Juri Workspace</p>
                <h2 class="text-3xl font-black tracking-[-0.04em] text-white sm:text-4xl">Hasil & Podium Lomba</h2>
                <p class="mt-1 text-sm text-slate-300">{{ $perlombaan->nama_lomba }}</p>
            </div>
            <a href="{{ route('juri.penilaian.submissions', $perlombaan) }}" class="inline-flex items-center justify-center rounded-2xl border border-neutral-700 bg-[#0a0a0c] px-5 py-3 text-sm font-bold text-white transition hover:border-amber-400">
                Kembali ke Submission
            </a>
        </div>
    </x-slot>

    <div class="bg-black py-10" x-data>
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8">
            
            <x-page-hero eyebrow="Hasil Akhir" title="Podium dan ranking final." description="Halaman ini bersifat baca saja untuk memantau hasil akhir." accent="orange">
                <div class="flex flex-wrap gap-3">
                    <a href="#podium" class="inline-flex items-center justify-center rounded-2xl bg-red-700 px-5 py-3 text-sm font-bold text-white hover:bg-red-600 transition-all shadow-[0_0_30px_rgba(220,38,38,0.6)]">Lihat Podium</a>
                </div>
            </x-page-hero>

            <section id="podium" class="rounded-[2rem] border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl">
                <h3 class="text-2xl font-black text-white mb-8 uppercase tracking-widest">Podium Utama</h3>
                <div class="grid gap-6 lg:grid-cols-3">
                    @foreach ($podium as $participant)
                        @php
                            $colors = [
                                1 => 'border-amber-400 bg-gradient-to-br from-amber-600/30 via-black to-black shadow-[0_0_60px_rgba(251,191,36,0.3)]',
                                2 => 'border-slate-400 bg-gradient-to-br from-slate-600/30 via-black to-black shadow-[0_0_60px_rgba(156,163,175,0.3)]',
                                3 => 'border-orange-700 bg-gradient-to-br from-orange-900/40 via-black to-black shadow-[0_0_60px_rgba(194,65,12,0.3)]'
                            ];
                            $activeClass = $colors[$loop->iteration] ?? 'border-neutral-800 bg-[#050505]';
                        @endphp

                        <article class="tilt-card relative overflow-hidden rounded-[2rem] border-2 p-6 transition-all duration-300 {{ $activeClass }} hover:scale-[1.03]">
                            <div class="absolute top-0 left-0 w-full h-1 bg-white/40"></div>
                            <p class="text-[11px] font-black uppercase tracking-widest mb-4 text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.8)]">
                                Juara {{ $participant->ranking_position }}
                            </p>
                            <h4 class="text-3xl font-black text-white drop-shadow-md">{{ $participant->user->name }}</h4>
                            <p class="mt-2 text-sm text-slate-200 font-bold">{{ $participant->submission_title }}</p>
                            <div class="mt-6 p-4 rounded-xl bg-black/50 border border-white/10">
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
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-800">
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
                                        {{ $registration->user->name }}
                                        @if($registration->ranking_position <= 3)
                                            <span class="ml-2 text-[10px] font-black uppercase px-2 py-0.5 rounded-full {{ $registration->ranking_position == 1 ? 'bg-amber-400 text-black' : ($registration->ranking_position == 2 ? 'bg-slate-300 text-black' : 'bg-orange-500 text-white') }}">Top {{ $registration->ranking_position }}</span>
                                        @endif
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
            el.addEventListener('mousemove', (e) => {
                const rect = el.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;
                el.style.transform = `perspective(1000px) rotateY(${x * 5}deg) rotateX(${y * -5}deg) scale(1.01)`;
            });
            el.addEventListener('mouseleave', () => {
                el.style.transform = `perspective(1000px) rotateY(0deg) rotateX(0deg) scale(1)`;
            });
        });
    </script>
</x-app-layout>