@props([
    'title' => null,
    'subtitle' => null,
    'titleSize' => '4xl'
])
<div>
    <h2 {{ $attributes->merge(['class' => 'text-orange-600 font-black text-2xl md:text-' . $titleSize]) }}>{{$title}}</h2>
    @empty(!$subtitle)
        <p class="text-gray-600">{{$subtitle}}</p>
    @endempty
</div>
