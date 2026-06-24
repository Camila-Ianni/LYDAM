@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2']) }}>
    {{ $value ?? $slot }}
</label>
