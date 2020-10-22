@props([
    'inputWidth' => 'full',
])
<div class="relative w-full">
    <div @click="open = !open" class="w-{{$inputWidth}}">
        <div class="absolute top-0 right-0 pointer-events-none text-gray-400 py-3 pr-3">
            <svg class="w-2 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9.143 16"><path d="M4.571 0a1.143 1.143 0 01.808.335l3.429 3.429A1.143 1.143 0 117.192 5.38l-2.62-2.621L1.951 5.38A1.143 1.143 0 11.335 3.763L3.763.335A1.143 1.143 0 014.571 0zM.335 10.621a1.143 1.143 0 011.616 0l2.621 2.621 2.621-2.621a1.143 1.143 0 111.616 1.616L5.38 15.665a1.143 1.143 0 01-1.616 0L.335 12.237a1.143 1.143 0 010-1.616z"/></svg>
        </div>

        <select
            {{ $attributes }}
            class="w-full border border-gray-300 bg-gray-100 leading-none rounded p-3 appearance-none focus:outline-none focus:bg-white focus:border-gray-400 capitalize"
        >
            {{ $slot }}
        </select>
    </div>
</div>
