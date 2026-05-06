@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'accent' => 'sky',
])

@php
    $eyebrowClasses = match ($accent) {
        'orange' => 'text-amber-400',
        'emerald' => 'text-emerald-400',
        default => 'text-sky-400',
    };

    $panelClasses = match ($accent) {
        'orange' => 'from-[#130808] via-[#0a0a0c] to-[#1a1205]',
        'emerald' => 'from-[#08110b] via-[#0a0a0c] to-[#071411]',
        default => 'from-[#081018] via-[#0a0a0c] to-[#06131a]',
    };
@endphp

<section {{ $attributes->class(["rounded-[2rem] border border-neutral-800 bg-gradient-to-br {$panelClasses} p-6 shadow-2xl sm:p-8"]) }}>
    @if ($eyebrow)
        <p class="text-sm font-bold uppercase tracking-[0.22em] {{ $eyebrowClasses }}">{{ $eyebrow }}</p>
    @endif

    <h3 class="mt-2 text-2xl font-black tracking-[-0.03em] text-white sm:text-3xl">{{ $title }}</h3>

    @if ($description)
        <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-300 sm:text-base">{{ $description }}</p>
    @endif

    @if (trim($slot))
        <div class="mt-6">
            {{ $slot }}
        </div>
    @endif
</section>
