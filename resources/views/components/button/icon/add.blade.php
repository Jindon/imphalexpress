@props([
'iconWidth' => '4',
])

<button
    {{ $attributes->merge(['class' => 'flex items-center p-2 text-sm rounded border border-orange-600 transition duration-200 focus:outline-none text-orange-600 hover:bg-orange-600 hover:text-orange-100']) }}
>
    <x-icon type="add" width="{{ $iconWidth }}"></x-icon>
</button>
