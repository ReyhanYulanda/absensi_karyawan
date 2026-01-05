@props([
    'class' => 'h-10 w-auto'
])

@php
    $logo = cache()->rememberForever('app_logo', function () {
        return \App\Models\Setting::where('key', 'app_logo')->value('value');
    });
@endphp

@if ($logo)
    <img
        src="{{ asset('storage/' . $logo) }}"
        alt="App Logo"
        {{ $attributes->merge(['class' => $class]) }}
    >
@else
    {{-- DEFAULT SVG --}}
    <svg viewBox="0 0 316 316"
         xmlns="http://www.w3.org/2000/svg"
         {{ $attributes->merge(['class' => $class]) }}>
        <path d="M305.8 81.125C305.77 80.995 305.69 80.885 ... 139.625H297.2Z"/>
    </svg>
@endif
