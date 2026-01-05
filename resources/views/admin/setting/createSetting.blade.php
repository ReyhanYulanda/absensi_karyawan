<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ➕ Tambah Setting
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-6">
        <form method="POST" id="form-setting" action="{{ route('setting.store') }}" 
              class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 space-y-6">
            @csrf

            <div>
                <label for="key" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Key
                </label>
                <input type="text" name="key" id="key" required
                       value="{{ old('key') }}"
                       class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                              focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                <x-input-error :messages="$errors->get('key')" class="mt-2" />
            </div>

            <div>
                <label for="value" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Value
                </label>
                <input type="text" name="value" id="value" required
                       value="{{ old('value') }}"
                       class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                              focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                <x-input-error :messages="$errors->get('value')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3">
                <x-cancel-button :href="route('setting.index')">
                    Batal
                </x-cancel-button>
                <x-save-button :formId="'form-setting'">
                    Simpan
                </x-save-button>
            </div>
        </form>
    </div>
</x-app-layout>
