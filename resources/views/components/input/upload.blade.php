@props([
    'id' => 'upload',
])
<div x-data="{ focused: false }">
    <label for="{{ $id }}"
        class="py-4 px-6 text-sm border rounded border-gray-300 transition duration-200 hover:bg-gray-200 cursor-pointer"
        x-bind:class="{ 'outline-none border-gray-500 bg-white': focused }"
    >
        {{ $slot }}
    </label>
    <input
        {{ $attributes }}
        id="{{ $id }}"
        @focus="focus = true"
        @blur="focus = false"
        class="hidden"
        type="file"
    >
</div>
