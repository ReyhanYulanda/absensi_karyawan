@props(['href' => null])

<a href="{{ $href }}" 
    {{ $attributes->merge([
        'class' => 'inline-block px-4 py-2 bg-yellow-400 rounded-lg font-semibold text-white hover:bg-yellow-700'
    ]) }}>
    ✏️ {{ $slot }}
</a>
