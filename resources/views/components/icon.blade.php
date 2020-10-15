@props([
    'width' => '4',
    'type' => 'search'
])

@switch($type)
    @case('search')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16.001">
            <path d="M6 2.001a4 4 0 104 4 4 4 0 00-4-4zm-6 4a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 11-1.414 1.414l-4.816-4.816A6 6 0 010 6.001z" />
        </svg>
        @break
    @case('delete')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 22.857">
            <path d="M8.571 0a1.429 1.429 0 00-1.277.79L6.26 2.857H1.429a1.429 1.429 0 100 2.857V20a2.857 2.857 0 002.857 2.857h11.428A2.857 2.857 0 0018.571 20V5.714a1.429 1.429 0 100-2.857H13.74L12.706.79A1.429 1.429 0 0011.429 0zM5.714 8.571a1.429 1.429 0 112.857 0v8.571a1.429 1.429 0 11-2.857 0zm7.143-1.429a1.429 1.429 0 00-1.429 1.429v8.571a1.429 1.429 0 102.857 0V8.571a1.429 1.429 0 00-1.428-1.428z" fill-rule="evenodd"/>
        </svg>
        @break
    @case('edit')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
            <path class="a" d="M10.586.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM8.379 2.793L0 11.172V14h2.828l8.38-8.379-2.83-2.828z"/>
        </svg>
        @break
    @case('status')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path d="M16 8a8 8 0 11-8-8 8 8 0 018 8zM9 4a1 1 0 11-1-1 1 1 0 011 1zM7 7a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 000-2V8a1 1 0 00-1-1z" fill-rule="evenodd"/>
        </svg>
        @break
    @case('selector')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9.143 16">
            <path d="M4.571 0a1.143 1.143 0 01.808.335l3.429 3.429A1.143 1.143 0 117.192 5.38l-2.62-2.621L1.951 5.38A1.143 1.143 0 11.335 3.763L3.763.335A1.143 1.143 0 014.571 0zM.335 10.621a1.143 1.143 0 011.616 0l2.621 2.621 2.621-2.621a1.143 1.143 0 111.616 1.616L5.38 15.665a1.143 1.143 0 01-1.616 0L.335 12.237a1.143 1.143 0 010-1.616z"/>
        </svg>
        @break
    @case('upload')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 18.285">
            <path d="M0 17.143A1.143 1.143 0 011.143 16h13.714a1.143 1.143 0 110 2.286H1.143A1.143 1.143 0 010 17.143zM3.763 5.379a1.143 1.143 0 010-1.616L7.192.334a1.143 1.143 0 011.616 0l3.429 3.429A1.143 1.143 0 1110.62 5.38L9.143 3.9v8.67a1.143 1.143 0 01-2.286 0V3.9L5.379 5.379a1.143 1.143 0 01-1.616 0z" />
        </svg>
        @break
    @case('close')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
            <path d="M.733.732a2.5 2.5 0 013.535 0L15 11.465 25.732.732a2.5 2.5 0 113.535 3.535L18.535 15l10.732 10.732a2.5 2.5 0 11-3.535 3.535L15 18.535 4.267 29.267a2.5 2.5 0 11-3.535-3.535L11.465 15 .733 4.267a2.5 2.5 0 010-3.535z" fill-rule="evenodd"/>
        </svg>
        @break
    @case('add')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M10 20A10 10 0 100 10a10 10 0 0010 10zm1.25-13.75a1.25 1.25 0 10-2.5 0v2.5h-2.5a1.25 1.25 0 100 2.5h2.5v2.5a1.25 1.25 0 002.5 0v-2.5h2.5a1.25 1.25 0 000-2.5h-2.5z" fill-rule="evenodd"/>
        </svg>
        @break
    @case('phone')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M0 1.25A1.25 1.25 0 011.25 0h2.691a1.25 1.25 0 011.233 1.045L6.1 6.589a1.25 1.25 0 01-.675 1.325L3.49 8.88a13.8 13.8 0 007.631 7.631l.967-1.935a1.25 1.25 0 011.324-.675l5.544.925A1.25 1.25 0 0120 16.059v2.691A1.25 1.25 0 0118.75 20h-2.5A16.25 16.25 0 010 3.75z" />
        </svg>
        @break
    @case('email')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 12">
            <path class="a" d="M0 1.884l8 4 8-4A2 2 0 0014 0H2a2 2 0 00-2 1.884z"/>
            <path class="a" d="M16 4.118l-8 4-8-4V10a2 2 0 002 2h12a2 2 0 002-2z"/>
        </svg>
        @break
    @case('info')
        <svg class="w-{{$width}} h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.986 19.003">
            <g transform="translate(-1.013 -1.997)">
                <path class="a" d="M22.56 16.3L14.89 3.58a3.43 3.43 0 00-5.78 0L1.44 16.3a3 3 0 00-.05 3A3.37 3.37 0 004.33 21h15.34a3.37 3.37 0 002.94-1.66 3 3 0 00-.05-3.04zm-1.7 2.05a1.31 1.31 0 01-1.19.65H4.33a1.31 1.31 0 01-1.19-.65 1 1 0 010-1l7.68-12.73a1.48 1.48 0 012.36 0l7.67 12.72a1 1 0 01.01 1.01z"/>
                <circle class="a" cx="1" cy="1" r="1" transform="translate(11 15)"/>
                <path class="a" d="M12 8a1 1 0 00-1 1v4a1 1 0 002 0V9a1 1 0 00-1-1z"/>
            </g>
        </svg>
        @break
    @default
@endswitch
