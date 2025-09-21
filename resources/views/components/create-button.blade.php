@props(['href' => null])

<a href="{{ $href }}" 
    {{ $attributes->merge([
        'class' => 'inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow'
    ]) }}>
    + <span class="hidden sm:inline ml-1">{{ $slot }}</span>
</a>
