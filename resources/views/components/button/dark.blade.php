@props([
'icon' => null,
'iconWidth' => '4',
])

<button
    {{ $attributes->merge(['class' => 'flex items-start px-6 py-3 text-sm leading-none rounded transition duration-200 focus:outline-none bg-gray-800 hover:bg-gray-900 text-gray-100']) }}
>
    {{ $slot }}

    @if($icon)
        <x-icon type="{{ $icon }}" width="{{ $iconWidth }}"></x-icon>
    @endif
</button>
