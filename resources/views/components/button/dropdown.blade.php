@props([
    'width' => 'full',
    'trigger' => 'Title',
])
<div class="relative w-full" x-data="{ open: false }" @click.away="open = false">
    <x-button
        @click="open = !open"
        class="w-{{ $width }} flex justify-between items-center leading-tight border border-gray-300 bg-white hover:bg-white rounded p-2 bg-gray-100"
        icon="selector" icon-width="2"
    >
        {{ $trigger }}
    </x-button>

    <!-- Options -->
    <div x-show="open" x-cloak @click="open = false" class="z-50 w-full absolute bg-white rounded border border-gray-300 shadow-lg right-0 top-0 mt-12">
        {{ $slot }}
    </div>
</div>
