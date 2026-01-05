<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">⚙️ Daftar Setting</h2>
            <x-create-button :href="route('setting.create')">
                Tambah setting
            </x-create-button>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">
                🖼️ Logo Aplikasi
            </h3>

            <form action="{{ route('setting.updateLogo') }}" 
                method="POST" 
                enctype="multipart/form-data"
                class="flex items-center gap-4">
                @csrf

                <input type="file"
                    name="logo"
                    accept="image/*"
                    required
                    class="block w-full text-sm text-gray-500">

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Upload
                </button>
            </form>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Key</th>
                        <th class="px-4 py-3">Value</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($settings as $setting)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-200">{{ $setting->key }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-200">{{ $setting->value }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex flec justify-center gap-2">
                                    <x-edit-button :href="route('setting.edit', $setting->id)">
                                        Edit
                                    </x-edit-button>
                                    <form id="delete-form-{{ $setting->id }}" 
                                        action="{{ route('setting.destroy', $setting->id) }}" 
                                        method="POST" 
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-button :form-id="'delete-form-' . $setting->id" :message="'Data setting akan dihapus permanen!'">
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
