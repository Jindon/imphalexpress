@props([
    'color' => 'gray',
])

<span {{ $attributes->merge(['class' => 'rounded-lg text-xs p-2 bg-' . $color . '-200 text-'. $color . '-800']) }}>
    {{ $slot }}
</span>
