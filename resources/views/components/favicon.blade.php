@php
    $favicon = cache()->rememberForever('app_favicon', function () {
        return \App\Models\Setting::where('key', 'app_favicon')->value('value');
    });
@endphp

@if ($favicon)
    <link rel="icon"
          type="image/png"
          href="{{ asset('storage/' . $favicon) }}?v={{ filemtime(public_path('storage/' . $favicon)) }}">
@endif
