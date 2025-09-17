@props(['href' => null])

<a href="{{ $href }}" 
    {{ $attributes->merge([
        'class' => 'inline-block bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow'
    ]) }}>
    ⬅️ {{ $slot }}
</a>
