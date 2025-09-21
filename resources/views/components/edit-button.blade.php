@props(['href' => null])

<a href="{{ $href }}" 
    {{ $attributes->merge([
        'class' => 'inline-block px-4 py-2 bg-yellow-400 rounded-lg font-semibold text-white hover:bg-yellow-700'
    ]) }}>
    ✏️ <span class="hidden sm:inline ml-1">{{ $slot }}</span>
</a>
