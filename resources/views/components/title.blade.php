@props([
    'title' => null,
    'subtitle' => null,
    'titleSize' => 'text-xl md:text-4xl'
])
<div>
    <h2 {{ $attributes->merge(['class' => 'text-orange-600 font-black text-2xl ' . $titleSize]) }}>
        {{$title}}
    </h2>
    @empty(!$subtitle)
        <p class="text-gray-600">{{$subtitle}}</p>
    @endempty
</div>
