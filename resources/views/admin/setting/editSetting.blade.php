<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">✏️ Edit Setting</h2>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="form-setting" action="{{ route('setting.update', $setting->id) }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="key" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Key</label>
                <input type="text" name ="key" id="key"
                    value="{{ old('key', $setting->key) }}"
                    class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <div class="mb-4">
                <label for="value" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Value</label>
                <input type="text" name="value" id="value"
                    value="{{ old('value', $setting->value) }}"
                    class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <div class="flex items-center justify-between mt-6">
                <x-cancel-button :href="route('setting.index')">
                    Batal
                </x-cancel-button>
                <x-save-button :formId="'form-setting'" :message="'Yakin ingin mengubah data ini?'"> 
                    Simpan Perubahan
                </x-save-button>
            </div>
        </form>
    </div>
</x-app-layout>
