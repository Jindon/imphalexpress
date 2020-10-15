@props([
    'inputWidth' => 'full',
    'iconWidth' => '4',
    'icon' => null
])

<div class="relative flex">
    @if($icon)
        <div class="absolute right-0 top-0 px-2 py-3 text-gray-400 pointer-events-none">
            <x-icon type="{{$icon}}"></x-icon>
        </div>
    @endif
    <input
        class="w-{{$inputWidth}} p-2 pr-8 rounded border border-gray-300 bg-gray-100 placeholder-gray-400 focus:outline-none focus:border-gray-400 focus:bg-white"
        {{ $attributes }}
    >
</div>
