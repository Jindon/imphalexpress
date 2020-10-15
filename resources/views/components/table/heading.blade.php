@props([
    'sortable' => null,
    'direction' => null,
])
<th {{ $attributes->merge(['class' => 'px-2 py-4 text-left'])->only('class') }}>
    @unless($sortable)
        <div class="uppercase text-xs text-gray-600 tracking-wide">{{ $slot }}</div>
    @else
        <button {{$attributes->except('class')}} class="group flex items-center space-x-3 focus:outline-none">
            <span class="flex items-center font-bold text-gray-600 text-xs leading-tight tracking-wide uppercase group-hover:text-gray-700">
                {{ $slot }}
            </span>

            <span class="text-gray-500 group-hover:text-gray-700">
                @if($direction === 'asc')
                    <svg class="w-2 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 16"><path d="M.293 5.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 11-1.414 1.414L6 3.414V15a1 1 0 01-2 0V3.414L1.707 5.707a1 1 0 01-1.414 0z" fill-rule="evenodd"/></svg>
                @elseif($direction === 'desc')
                    <svg class="w-2 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 16"><path d="M9.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L4 12.586V1a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" fill-rule="evenodd"/></svg>
                @else
                    <svg class="w-2 h-auto transition duration-300 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14"><path d="M4 0a1 1 0 01.707.293l3 3a1 1 0 11-1.414 1.414L4 2.414 1.707 4.707A1 1 0 11.293 3.293l3-3A1 1 0 014 0zM.293 9.293a1 1 0 011.414 0L4 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" fill-rule="evenodd"/></svg>
                @endif
            </span>
        </button>
    @endunless
</th>
