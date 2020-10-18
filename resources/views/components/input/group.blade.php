@props([
    'label',
    'for',
    'error',
])

<div>
    <label class="text-sm text-gray-600" for="{{ $for }}">
        {{ $label }}
    </label>

    {{ $slot }}
    @isset($error)
        <span class="text-sm text-red-500 pt-1">{{ $error }}</span>
    @endisset
</div>
