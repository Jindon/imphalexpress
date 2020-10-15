@props([
    'color' => 'gray',
    'icon' => 'status'
])
<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <x-button
        @click="open = !open"
        icon="{{ $icon }}"
        class="text-{{ $color }}-600 focus:bg-gray-200"
    ></x-button>

    <!-- Dropdown options -->
    <div x-show="open" x-cloak @click="open = false" class="z-50 absolute top-0 right-0 mt-8 bg-white border border-gray-300 shadow rounded">
        {{ $slot }}
    </div>
</div>
