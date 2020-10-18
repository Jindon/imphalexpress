@props([
    'width' => 'full',
    'trigger' => 'Title',
])
<div class="relative w-full" x-data="{ open: false }" @click.away="open = false">
{{--    <button @click="open = !open" class="w-{{$width}} flex justify-between items-center bg-gray-100 p-2 focus:outline-none focus:border-gray-400 focus:bg-white">--}}
{{--        <div class="capitalize" x-text="'{{$trigger}}'"></div>--}}
{{--        <div class="text-gray-400">--}}
{{--            <x-icon type="selector" width="2"/>--}}
{{--        </div>--}}
{{--    </button>--}}
    <x-button
        @click="open = !open"
        class="w-{{ $width }} flex justify-between items-center border border-gray-300 bg-white hover:bg-white rounded p-3 bg-gray-100"
        icon="selector" icon-width="2"
    ></x-button>

    <!-- Options -->
    <div x-show="open" x-cloak @click="open = false" class="z-50 w-full absolute bg-white rounded border border-gray-300 shadow-lg right-0 top-0 mt-12">
        {{ $slot }}
    </div>
</div>
