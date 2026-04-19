<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 w-fit border border-indigo-100">
                <span class="material-symbols-outlined text-[14px] text-[#1e2460]">admin_panel_settings</span>
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#1e2460]">Admin Control Center</span>
            </div>
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                Halo, {{ explode(' ', $user->name)[0] }}
            </h2>
            <p class="max-w-2xl text-base leading-relaxed text-slate-500">
                Ringkasan performa sistem dan manajemen operasional kompetisi untuk hari ini.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        @php
            $metricClasses = [
                'sky' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                'orange' => 'bg-amber-50 text-amber-700 border-amber-100',
                'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                'slate' => 'bg-slate-100 text-slate-700 border-slate-200',
            ];
        @endphp

        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8">
            
            <div class="grid gap-6 lg:grid-cols-[1fr_0.8fr]">
                <div class="flex flex-col justify-center rounded-[2rem] border border-slate-100 bg-white p-8 shadow-sm">
                    <h3 class="text-2xl font-bold tracking-tight text-slate-900">Performa Sistem Lomba</h3>
                    <p class="mt-3 text-[15px] leading-relaxed text-slate-500">
                        Pantau progres pendaftaran, beban review juri, dan distribusi nilai secara real-time dari satu tampilan terpadu.
                    </p>
                    <div class="mt-6 flex items-center gap-4">
                        <div class="h-2 flex-1 rounded-full bg-slate-100">
                            <div class="h-2 w-[75%] rounded-full bg-[#1e2460]"></div>
                        </div>
                        <span class="text-sm font-bold text-slate-700">75% Progres</span>
                    </div>
                </div>

                <div class="rounded-[2rem] bg-[#1e2460] p-8 text-white shadow-lg shadow-indigo-900/20">
                    <div class="flex items-center justify-between">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-indigo-200">Akses Otoritas</p>
                        <span class="material-symbols-outlined text-indigo-300">verified_user</span>
                    </div>
                    <p class="mt-4 text-3xl font-bold tracking-tight">{{ ucfirst($user->role) }} Panel</p>
                    <p class="mt-3 text-sm leading-relaxed text-indigo-100/80">Akses penuh untuk manajemen pengguna, kriteria lomba, dan publikasi hasil pengumuman.</p>
                </div>
            </div>

            <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats['metrics'] as $metric)
                    <article class="rounded-[2rem] border border-slate-100 bg-white p-6 shadow-sm transition-all hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ $metric['label'] }}</p>
                            <span class="inline-flex rounded-full border px-2.5 py-0.5 text-[10px] font-bold uppercase {{ $metricClasses[$metric['tone']] ?? $metricClasses['slate'] }}">
                                {{ $metric['tone'] }}
                            </span>
                        </div>
                        <p class="mt-4 text-4xl font-bold tracking-tight text-[#1e2460]">{{ $metric['value'] }}</p>
                        <p class="mt-2 text-[13px] font-medium text-slate-500">{{ $metric['helper'] }}</p>
                    </article>
                @endforeach
            </section>

            <section class="grid gap-8 lg:grid-cols-2">
                <article class="rounded-[2rem] border border-slate-100 bg-white p-8 shadow-sm">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-slate-900">Alur Kerja Cepat</h3>
                        <p class="mt-2 text-sm text-slate-500">Akses langsung ke modul operasional paling krusial.</p>
                    </div>
                    
                    <div class="grid gap-4">
                        @foreach ($stats['quickActions'] as $action)
                            <a href="{{ $action['href'] }}" class="group flex items-center justify-between rounded-2xl border border-slate-50 bg-slate-50/50 p-4 transition-all hover:border-indigo-100 hover:bg-white hover:shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-[#1e2460] shadow-sm transition-colors group-hover:bg-[#1e2460] group-hover:text-white">
                                        <span class="material-symbols-outlined text-[20px]">
                                            {{ $action['label'] == 'Kelola User' ? 'group' : ($action['label'] == 'Kelola Perlombaan' ? 'inventory_2' : 'campaign') }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-slate-900">{{ $action['label'] }}</p>
                                        <p class="text-xs text-slate-500">Masuk ke modul manajemen</p>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-slate-300 transition-transform group-hover:translate-x-1 group-hover:text-[#1e2460]">chevron_right</span>
                            </a>
                        @endforeach
                    </div>
                </article>

                <article class="rounded-[2rem] border border-slate-100 bg-slate-50/50 p-8 shadow-sm">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-slate-900">Distribusi Kondisi</h3>
                        <p class="mt-2 text-sm text-slate-500">Ringkasan status seluruh item yang sedang dikelola.</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ($stats['statusCards'] as $card)
                            <div class="rounded-2xl border border-white bg-white p-5 shadow-sm">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="h-2 w-2 rounded-full {{ $metricClasses[$card['tone']] ?? 'bg-slate-400' }}"></div>
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ $card['label'] }}</p>
                                </div>
                                <p class="text-3xl font-bold text-slate-900">{{ $card['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>

            <section class="grid gap-8 xl:grid-cols-2">
                <article class="rounded-[2rem] border border-slate-100 bg-white p-8 shadow-sm">
                    <div class="mb-8 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">{{ $stats['primaryList']['title'] }}</h3>
                            <p class="mt-1 text-sm text-slate-500">Update perlombaan yang baru ditambahkan.</p>
                        </div>
                        <span class="material-symbols-outlined text-slate-300">list_alt</span>
                    </div>

                    <div class="space-y-4">
                        @forelse ($stats['primaryList']['items'] as $item)
                            <div class="group relative rounded-2xl border border-slate-50 bg-slate-50/50 p-5 transition-all hover:border-indigo-100 hover:bg-white">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-lg font-bold text-slate-900">{{ $item['title'] }}</h4>
                                        <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                            <span>{{ $item['meta'] }}</span>
                                            <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                            <span class="font-medium text-indigo-600">{{ $item['badge'] }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ $item['href'] }}" class="inline-flex h-9 items-center justify-center rounded-xl bg-white px-4 text-xs font-bold text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-[#1e2460] hover:text-white hover:ring-transparent">
                                        {{ $item['link_label'] }}
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center text-sm text-slate-400">
                                {{ $stats['primaryList']['empty'] }}
                            </div>
                        @endforelse
                    </div>
                </article>

                <article class="rounded-[2rem] border border-slate-100 bg-white p-8 shadow-sm">
                    <div class="mb-8 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">{{ $stats['secondaryList']['title'] }}</h3>
                            <p class="mt-1 text-sm text-slate-500">Pendaftaran terbaru yang masuk ke sistem.</p>
                        </div>
                        <span class="material-symbols-outlined text-slate-300">history</span>
                    </div>

                    <div class="space-y-4">
                        @forelse ($stats['secondaryList']['items'] as $item)
                            <div class="flex items-center justify-between rounded-2xl border border-slate-50 bg-white p-5 transition-all hover:bg-slate-50/50">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-50 text-orange-600 font-bold text-xs">
                                        {{ substr($item['title'], 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-slate-900">{{ $item['title'] }}</h4>
                                        <p class="text-xs text-slate-500">{{ $item['meta'] }}</p>
                                    </div>
                                </div>
                                <a href="{{ $item['href'] }}" class="text-xs font-bold text-indigo-600 hover:underline">
                                    {{ $item['link_label'] }}
                                </a>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center text-sm text-slate-400">
                                {{ $stats['secondaryList']['empty'] }}
                            </div>
                        @endforelse
                    </div>
                </article>
            </section>
        </div>
    </div>
</x-app-layout>