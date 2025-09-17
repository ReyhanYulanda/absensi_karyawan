@props(['formId', 'message' => 'Yakin ingin menghapus data ini?'])

<button type="button"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs shadow dark:shadow-gray-900']) }}
    onclick="confirmDelete('{{ $formId }}', '{{ $message }}')">
    {{ $slot }}
</button>
