@props([
    'inputWidth' => 'full'
])

<div class="relative flex" x-data="{ show: false }">
    <div class="absolute right-0 top-0 px-2 py-2 text-gray-400">
        <button class="p-1" :class="{ 'block': !show, 'hidden': show }" @click.prevent="show = true">
            <x-icon type="eye" width="5"/>
        </button>
        <button class="p-1" :class="{ 'block': show, 'hidden': !show }" @click.prevent="show = false">
            <x-icon type="eye-close" width="5"/>
        </button>
    </div>
    <input
        class="w-{{$inputWidth}} p-2 pr-8 rounded border border-gray-300 bg-gray-100 placeholder-gray-400 focus:outline-none focus:border-gray-400 focus:bg-white"
        :type="show ? 'text' : 'password'"
        {{ $attributes }}
    >
</div>
