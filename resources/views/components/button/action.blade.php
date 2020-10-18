@props([
    'icon' => 'status'
])
<div class="relative" x-data="{ open: false }" @click.away="open = false">
    @switch($icon)
        @case('status')
            <x-button.icon.status @click="open = !open"/>
            @break
        @default
            @break
    @endswitch

    <!-- Dropdown options -->
    <div x-show="open" x-cloak @click="open = false" class="z-50 absolute top-0 right-0 mt-8 bg-white border border-gray-300 shadow rounded">
        {{ $slot }}
    </div>
</div>
