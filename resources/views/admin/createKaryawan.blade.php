<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __(' Tambah Karyawan') }}
        </h1>
    </x-slot>

    <div class="container py-6">
        <form method="POST" action="{{ route('karyawan.store') }}">
            @csrf

            <div>
                <label for="name">Nama Karyawan</label>
                <input type="text" name="name" id="name" required>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div>
                <label for="role">Role</label>
                <select name="role" id="role" required
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="karyawan">Karyawan</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <x-primary-button>
                Submit
            </x-primary-button>

        </form>
    </div>
</x-app-layout>
