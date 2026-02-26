@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-black text-lg text-blue-600 mb-2 tracking-wide drop-shadow-sm']) }}>
    {{ $value ?? $slot }}
</label>