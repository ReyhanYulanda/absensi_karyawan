@props(['formId', 'message' => 'Yakin ingin menghapus data ini?'])

<button type="button"
    {{ $attributes->merge(['class' => 'inline-block px-4 py-2 bg-red-600 rounded-lg font-semibold text-white hover:bg-red-700']) }}
    onclick="confirmDelete('{{ $formId }}', '{{ $message }}')">
    🗑 {{ $slot }}
</button>
