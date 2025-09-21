<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">👥 Daftar Karyawan</h2>
            <x-create-button :href="route('karyawan.create')">
                Tambah karyawan
            </x-create-button>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="w-full text-xs sm:text-sm text-left border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-200">{{ $user->name }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-200">{{ $user->username }}</td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap
                                    {{ $user->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $user->status ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex flec justify-center gap-2">
                                    <x-edit-button :href="route('karyawan.edit', $user->id)">
                                        Edit
                                    </x-edit-button>
                                    <form id="delete-form-{{ $user->id }}" 
                                        action="{{ route('karyawan.destroy', $user->id) }}" 
                                        method="POST" 
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-button :form-id="'delete-form-' . $user->id" :message="'Data karyawan akan dihapus permanen!'">
                                            Hapus
                                        </x-delete-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
