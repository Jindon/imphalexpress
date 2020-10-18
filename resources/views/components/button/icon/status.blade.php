@props([
'iconWidth' => '4',
])

<button
    {{ $attributes->merge(['class' => 'flex items-center p-2 text-sm rounded transition duration-200 focus:outline-none text-gray-600 hover:bg-gray-600 hover:text-gray-100']) }}
>
    <x-icon type="status" width="{{ $iconWidth }}"></x-icon>
</button>
