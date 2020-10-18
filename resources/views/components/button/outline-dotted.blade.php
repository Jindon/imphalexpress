@props([
'icon' => null,
'iconWidth' => '4',
])

<button
    {{ $attributes->merge(['class' => 'flex items-start px-6 py-3 text-sm leading-none rounded border-2 border-dashed border-gray-300 text-gray-500 transition duration-200 hover:bg-gray-100 hover:text-gray-600 hover:border-gray-600']) }}
>
    {{ $slot }}

    @if($icon)
        <x-icon type="{{ $icon }}" width="{{ $iconWidth }}"></x-icon>
    @endif
</button>
