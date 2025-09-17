@props(['formId', 'message' => 'Yakin ingin menyimpan data ini?'])

<button type="button"
    {{ $attributes->merge([
        'class' => 'inline-block px-4 py-2 bg-blue-600 rounded-lg font-semibold text-white hover:bg-blue-700'
    ]) }}
    onclick="confirmSave('{{ $formId }}', '{{ $message }}')">
    💾 {{ $slot }}
</button>
