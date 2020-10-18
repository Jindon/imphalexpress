@props([
'icon' => null,
'iconWidth' => '4',
])

<button
    {{ $attributes->merge(['class' => 'flex items-start px-6 py-3 text-sm leading-none rounded border transition duration-200 focus:outline-none bg-red-600 hover:bg-red-700 text-red-100']) }}
>
    {{ $slot }}

    @if($icon)
        <x-icon type="{{ $icon }}" width="{{ $iconWidth }}"></x-icon>
    @endif
</button>
