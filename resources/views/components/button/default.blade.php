@props([
'icon' => null,
'iconWidth' => '4',
])

<button
    {{ $attributes->merge(['class' => 'flex items-start px-6 py-3 text-sm leading-none rounded border focus:outline-none bg-gray-200 text-gray-600 transition duration-200 hover:bg-gray-300 hover:text-gray-800']) }}
>
    {{ $slot }}

    @if($icon)
        <x-icon type="{{ $icon }}" width="{{ $iconWidth }}"></x-icon>
    @endif
</button>
