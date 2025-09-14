<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h2 class="text-xl font-bold mb-4">Daftar Karyawan</h2>

        <x-primary-button>
            <a href="{{ route('karyawan.create') }}">Tambah Karyawan</a>
        </x-primary-button>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-1 py-2">No</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Username</th>
                    <th class="border px-4 py-2">Role</th>
                    <th class="border px-2 py-2">Status</th>
                    <th class="border px-2 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->username }}</td>
                    <td class="border px-4 py-2">{{ $user->role }}</td>
                    <td class="border px-4 py-2">{{ $user->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td class="border px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
