@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full']) }}>
