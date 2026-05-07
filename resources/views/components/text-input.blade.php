@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-neutral-600 bg-[#0a0a0c] text-white focus:border-amber-400 focus:ring-amber-400 rounded-md shadow-sm placeholder-gray-400']) }}>
