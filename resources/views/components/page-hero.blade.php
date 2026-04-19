@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'accent' => 'sky',
])

@php
    $eyebrowClasses = match ($accent) {
        'orange' => 'text-orange-500',
        'emerald' => 'text-emerald-600',
        default => 'text-sky-600',
    };

    $panelClasses = match ($accent) {
        'orange' => 'from-orange-50 via-white to-amber-50',
        'emerald' => 'from-emerald-50 via-white to-teal-50',
        default => 'from-sky-50 via-white to-cyan-50',
    };
@endphp

<section {{ $attributes->class(["rounded-[2rem] border border-slate-200 bg-gradient-to-br {$panelClasses} p-6 shadow-sm sm:p-8"]) }}>
    @if ($eyebrow)
        <p class="text-sm font-bold uppercase tracking-[0.22em] {{ $eyebrowClasses }}">{{ $eyebrow }}</p>
    @endif

    <h3 class="mt-2 text-2xl font-black tracking-[-0.03em] text-slate-950 sm:text-3xl">{{ $title }}</h3>

    @if ($description)
        <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-600 sm:text-base">{{ $description }}</p>
    @endif

    @if (trim($slot))
        <div class="mt-6">
            {{ $slot }}
        </div>
    @endif
</section>
