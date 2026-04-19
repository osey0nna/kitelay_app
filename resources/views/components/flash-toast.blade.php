@if (session('status'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3500)"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed right-4 top-20 z-[70] w-[calc(100%-2rem)] max-w-md"
    >
        <div class="rounded-[1.5rem] border border-emerald-200 bg-white/95 p-4 shadow-[0_20px_50px_-20px_rgba(16,185,129,0.45)] backdrop-blur">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-600">Berhasil</p>
                    <p class="mt-1 text-sm leading-6 text-slate-700">{{ session('status') }}</p>
                </div>
                <button @click="show = false" type="button" class="rounded-full p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
        </div>
    </div>
@endif
