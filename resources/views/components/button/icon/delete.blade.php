@props([
    'iconWidth' => '4',
    'disabled' => false,
])

<button
    {{ $attributes->merge(['class' => 'flex items-center p-2 text-sm rounded transition duration-200 focus:outline-none text-red-600 ' . $disabled ? 'hover:bg-gray-300 cursor-not-allowed' : 'hover:bg-red-600 hover:text-red-100']) }}
    {{ $disabled ? 'disabled' : '' }}
>
    <x-icon type="delete" width="{{ $iconWidth }}"></x-icon>
</button>
