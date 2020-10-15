@props([
    'type' => 'gray',
])

<span {{ $attributes->merge(['class' => 'rounded-lg text-xs p-2 bg-' . $type . '-200 text-'. $type . '-800']) }}>
    {{ $slot }}
</span>
