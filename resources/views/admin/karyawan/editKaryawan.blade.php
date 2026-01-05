<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">✏️ Edit Karyawan</h2>

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

        <form id="form-karyawan" action="{{ route('karyawan.update', $user->id) }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <div class="mb-4">
                <label for="username" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Username</label>
                <input type="text" name="username" id="username"
                    value="{{ old('username', $user->username) }}"
                    class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <div class="mb-4">
                <label for="role" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Role</label>
                <select name="role" id="role"
                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ $user->role === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="status" id="status"
                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                    <option value="1" {{ $user->status ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$user->status ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="password" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Password Baru <span class="text-sm text-gray-500">(opsional)</span>
                </label>
                <input type="password" name="password" id="password"
                    class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                            focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                            focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
            </div>

            <div class="flex items-center justify-between mt-6">
                <x-cancel-button :href="route('karyawan.index')">
                    Batal
                </x-cancel-button>
                <x-save-button :formId="'form-karyawan'" :message="'Yakin ingin mengubah data ini?'"> 
                    Simpan Perubahan
                </x-save-button>
            </div>
        </form>
    </div>
</x-app-layout>
