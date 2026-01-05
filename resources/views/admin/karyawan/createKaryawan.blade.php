<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ➕ Tambah Karyawan
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-6">
        <form method="POST" id="form-karyawan" action="{{ route('karyawan.store') }}" 
              class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 space-y-6">
            @csrf

            {{-- Nama --}}
            <div>
                <label for="name" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Nama Karyawan
                </label>
                <input type="text" name="name" id="name" required
                       value="{{ old('name') }}"
                       class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                              focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Username --}}
            <div>
                <label for="username" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Username
                </label>
                <input type="text" name="username" id="username" required
                       value="{{ old('username') }}"
                       class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                              focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Password
                </label>
                <input type="password" name="password" id="password" required
                       class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                              focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                              focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Role
                </label>
                <select name="role" id="role" required
                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                               focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ old('role') === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-end gap-3">
                <x-cancel-button :href="route('karyawan.index')">
                    Batal
                </x-cancel-button>
                <x-save-button :formId="'form-karyawan'">
                    Simpan
                </x-save-button>
            </div>
        </form>
    </div>
</x-app-layout>
