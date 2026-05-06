<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 relative z-10">
            <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                <span class="material-symbols-outlined text-[16px] text-amber-400">admin_panel_settings</span>
                <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Admin Control Center</span>
            </div>
            
            <h2 class="text-3xl font-black tracking-tight text-white uppercase sm:text-4xl">
                Halo, <span class="text-amber-400 drop-shadow-[0_0_10px_rgba(251,191,36,0.5)]">{{ explode(' ', $user->name)[0] }}</span>
            </h2>
            <p class="max-w-2xl text-base font-medium leading-relaxed text-white">
                Ringkasan performa sistem dan metrik operasional kompetisi hari ini.
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-black min-h-screen relative overflow-hidden text-white" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-[150px] pointer-events-none z-0"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-amber-500/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        @php
            $metricClasses = [
                'sky' => 'bg-gradient-to-r from-red-900/60 to-black text-amber-400 border-l-2 border-amber-400',
                'orange' => 'bg-gradient-to-r from-orange-900/60 to-black text-orange-400 border-l-2 border-orange-500',
                'emerald' => 'bg-gradient-to-r from-emerald-900/60 to-black text-emerald-400 border-l-2 border-emerald-500',
                'slate' => 'bg-gradient-to-r from-neutral-800 to-black text-white border-l-2 border-slate-500',
            ];
        @endphp

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="grid gap-6 lg:grid-cols-[1fr_0.8fr] transition-all duration-700 ease-out"
                 :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                
                <div class="flex flex-col justify-center rounded-tl-3xl rounded-br-3xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-[0_0_20px_rgba(0,0,0,0.5)] hover:border-amber-500/30 hover:shadow-[0_0_30px_rgba(251,191,36,0.1)] transition-all">
                    <h3 class="text-2xl font-black uppercase tracking-wide text-white">Performa Sistem Lomba</h3>
                    <p class="mt-3 text-[14px] font-medium leading-relaxed text-white">
                        Pantau progres pendaftaran dan beban operasional sistem secara real-time.
                    </p>
                    <div class="mt-8 flex items-center gap-4">
                        <div class="h-2 flex-1 bg-neutral-900 skew-x-[-10deg] overflow-hidden">
                            <div class="h-full w-[75%] bg-gradient-to-r from-red-600 to-amber-400 relative shadow-[0_0_15px_rgba(251,191,36,0.5)]">
                                <div class="absolute inset-0 bg-white/20 animate-[shine_2s_infinite]"></div>
                            </div>
                        </div>
                        <span class="text-sm font-black uppercase tracking-widest text-amber-400 drop-shadow-[0_0_5px_rgba(251,191,36,0.5)]">75% Progres</span>
                    </div>
                </div>

                <div class="rounded-tl-3xl rounded-br-3xl rounded-tr-sm rounded-bl-sm bg-gradient-to-br from-red-700 to-red-950 p-8 text-white shadow-[0_0_30px_rgba(220,38,38,0.3)] border border-red-500/30 relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-amber-500/20 blur-[40px] rounded-full"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <p class="text-[11px] font-black uppercase tracking-widest text-red-200">Akses Otoritas</p>
                        <span class="material-symbols-outlined text-amber-400 text-3xl drop-shadow-[0_0_10px_rgba(251,191,36,0.8)]">verified_user</span>
                    </div>
                    <p class="mt-6 text-3xl font-black uppercase tracking-tight text-white drop-shadow-md">{{ ucfirst($user->role) }} Panel</p>
                    <p class="mt-3 text-[14px] font-medium leading-relaxed text-white">Sistem manajemen terpusat untuk kontrol penuh operasional kompetisi.</p>
                </div>
            </div>

            <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4 transition-all duration-700 delay-100 ease-out"
                     :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                @foreach ($stats['metrics'] as $metric)
                    <article class="rounded-tl-2xl rounded-br-2xl rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-6 shadow-lg hover:border-amber-500/50 hover:shadow-[0_0_25px_rgba(251,191,36,0.1)] transition-all hover:-translate-y-1 group relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-600 group-hover:bg-amber-400 transition-colors"></div>
                        <div class="flex items-center justify-between">
                            <p class="text-[11px] font-black uppercase tracking-widest text-white">{{ $metric['label'] }}</p>
                            <span class="inline-flex px-2 py-1 text-[9px] font-black uppercase shadow-sm {{ $metricClasses[$metric['tone']] ?? $metricClasses['slate'] }}">
                                {{ $metric['tone'] }}
                            </span>
                        </div>
                        <p class="mt-6 text-4xl font-black tracking-tight text-white group-hover:text-amber-400 transition-colors drop-shadow-[0_0_10px_rgba(255,255,255,0.1)]">{{ $metric['value'] }}</p>
                        <p class="mt-2 text-[12px] font-bold uppercase tracking-wider text-white">{{ $metric['helper'] }}</p>
                    </article>
                @endforeach
            </section>
        </div>
    </div>
</x-app-layout>