@props([
    'color' => 'gray',
])
<div {{ $attributes->merge(['class' => 'p-2 rounded border-2 border-'.$color.'-300 text-'.$color.'-700']) }}>
    {{ $slot }}
</div>
