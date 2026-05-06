<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between relative z-10">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-violet-500 bg-gradient-to-r from-violet-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(139,92,246,0.15)]">
                    <span class="material-symbols-outlined text-[16px] text-violet-400">leaderboard</span>
                    <span class="text-[11px] font-black uppercase tracking-widest text-violet-400">Admin Panel</span>
                </div>
                <h2 class="text-3xl font-black uppercase tracking-tight text-white sm:text-4xl drop-shadow-md">
                    Hasil <span class="text-violet-400">Perlombaan</span>
                </h2>
                <p class="max-w-2xl text-sm font-medium leading-7 text-slate-400">
                    Pilih lomba terlebih dulu untuk memantau data podium dan ranking.
                </p>
            </div>
            <a href="{{ route('admin.perlombaan.index') }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-transparent px-6 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-500 hover:text-white transition-all skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Kembali ke Perlombaan</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-violet-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out" :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">

            <section class="rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-violet-900/50 bg-[#0a0a0c] p-8 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-violet-400 to-violet-700"></div>
                <form method="GET" action="{{ route('admin.hasil.index') }}" class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-end">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-widest text-violet-400">Pilih Lomba</p>
                        <h3 class="mt-2 text-2xl font-black uppercase tracking-wide text-white">Tentukan lomba.</h3>
                        <select id="perlombaan" name="perlombaan" class="mt-4 w-full rounded-xl border border-neutral-700 bg-black px-4 py-3 text-sm font-bold text-white focus:border-violet-500">
                            <option value="">Pilih lomba</option>
                            @foreach ($competitions as $competition)
                                <option value="{{ $competition->id }}" @selected(optional($perlombaan)->id === $competition->id)>
                                    {{ $competition->nama_lomba }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-sm bg-gradient-to-r from-violet-600 to-indigo-800 px-8 py-4 text-[11px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(139,92,246,0.3)] transition-all hover:scale-105 skew-x-[-10deg]">
                        <span class="skew-x-[10deg]">Lihat Hasil</span>
                    </button>
                </form>
            </section>

            @if ($perlombaan)
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
                                <p class="text-[11px] font-black uppercase tracking-widest mb-4 text-white">Juara {{ $participant->ranking_position }}</p>
                                <h4 class="text-2xl font-black text-white">{{ $participant->user->name }}</h4>
                                <div class="mt-6 p-4 rounded-xl bg-black/50 border border-white/10">
                                    <p class="text-[10px] font-black uppercase text-slate-400">Skor Final</p>
                                    <p class="text-3xl font-black text-white">{{ number_format((float) $participant->final_score, 2) }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="overflow-hidden rounded-tl-[2rem] rounded-br-[2rem] border border-neutral-800 bg-[#0a0a0c] shadow-2xl">
                    <table class="min-w-full divide-y divide-neutral-800">
                        <tbody class="divide-y divide-neutral-800">
                            @foreach ($registrations as $registration)
                                @php
                                    $rank = $rankedRegistrations->firstWhere('id', $registration->id)?->ranking_position;
                                    $rowStyle = ($rank == 1) ? 'bg-gradient-to-r from-amber-500/20 to-transparent border-l-4 border-amber-400' : (($rank == 2) ? 'bg-gradient-to-r from-slate-400/20 to-transparent border-l-4 border-slate-300' : (($rank == 3) ? 'bg-gradient-to-r from-orange-700/20 to-transparent border-l-4 border-orange-500' : ''));
                                @endphp
                                <tr class="tilt-row group transition-all hover:bg-neutral-900/80 {{ $rowStyle }}">
                                    <td class="px-6 py-5 font-black text-white">#{{ $rank ?? '-' }}</td>
                                    <td class="px-6 py-5 font-bold text-white">
                                        {{ $registration->user->name }}
                                        @if($rank && $rank <= 3)
                                            <span class="ml-2 px-2 py-0.5 rounded-full text-[9px] font-black uppercase {{ $rank == 1 ? 'bg-amber-400 text-black' : ($rank == 2 ? 'bg-slate-300 text-black' : 'bg-orange-500 text-white') }}">
                                                Top {{ $rank }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 font-black text-amber-400 text-lg">{{ number_format((float) $registration->final_score, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            @endif
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
            el.addEventListener('mouseleave', () => el.style.transform = `none`);
        });
    </script>
</x-app-layout>