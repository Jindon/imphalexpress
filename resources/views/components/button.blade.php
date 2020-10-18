@props([
    'icon' => null,
    'iconWidth' => '4',
    'text' => null,
    'type' => 'default',
    'typeColor',
])

@php
    switch ($type) {
        case 'primary':
            $typeColor = 'border-gray-300 hover:bg-gray-200';
            break;
        case 'dark':
            $typeColor = 'bg-gray-800 text-gray-200 hover:bg-gray-900';
            break;
        case 'secondary':
            $typeColor = 'bg-gray-300 text-gray-700 hover:bg-gray-200';
            break;
        default:
            $typeColor = 'border-gray-300 hover:bg-gray-200';
            break;
    }
@endphp
<button
    {{ $attributes->merge(['class' => 'flex items-start px-4 py-3 text-sm rounded border transition duration-200 focus:outline-none ' . $typeColor]) }}
>
    {{ $slot }}

    @if($icon)
        <x-icon type="{{ $icon }}" width="{{ $iconWidth }}"/>
    @endif
</button>
