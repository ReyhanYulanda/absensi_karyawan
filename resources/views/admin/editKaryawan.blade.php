<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">✏️ Edit Karyawan</h2>

        {{-- Notifikasi sukses/error --}}
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

        <form action="{{ route('karyawan.update', $user->id) }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-4">
                <label for="name" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
            </div>

            {{-- Username --}}
            <div class="mb-4">
                <label for="username" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Username</label>
                <input type="text" name="username" id="username"
                       value="{{ old('username', $user->username) }}"
                       class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label for="role" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Role</label>
                <select name="role" id="role"
                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ $user->role === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label for="status" class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="status" id="status"
                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:text-gray-200">
                    <option value="1" {{ $user->status ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$user->status ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('karyawan.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    ⬅️ Kembali
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
