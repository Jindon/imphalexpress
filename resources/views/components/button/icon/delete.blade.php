@props([
'iconWidth' => '4',
])

<button
    {{ $attributes->merge(['class' => 'flex items-center p-2 text-sm rounded transition duration-200 focus:outline-none text-red-600 hover:bg-red-600 hover:text-red-100']) }}
>
    <x-icon type="delete" width="{{ $iconWidth }}"></x-icon>
</button>
