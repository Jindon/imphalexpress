@props([
    'type' => 'button',
    'href' => '#'
])
@if($type==='button')
    <button {{ $attributes->merge(['class' => 'text-gray-800 focus:outline-none transition duration-200 hover:text-orange-600 hover:underline']) }}>
        {{ $slot }}
    </button>
@endif
@if($type==='link')
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => 'text-gray-800 transition duration-200 hover:text-orange-600 hover:underline']) }}
    >
        {{ $slot }}
    </a>
@endif
