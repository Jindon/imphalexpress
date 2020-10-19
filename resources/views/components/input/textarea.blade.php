@props([
    'width' => 'full',
])

<textarea
    class="p-2 w-{{ $width }} rounded border border-gray-300 bg-gray-100 text-lg placeholder-gray-400 focus:outline-none focus:bg-white"
    {{ $attributes }}
></textarea>
