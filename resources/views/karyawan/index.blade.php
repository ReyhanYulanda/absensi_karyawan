<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Absensi Karyawan') }}
        </h1>
    </x-slot>

    <div class="container py-6">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <button type="submit" name="status" value="masuk" class="btn btn-success">Absen Masuk</button>
            <button type="submit" name="status" value="pulang" class="btn btn-danger">Absen Pulang</button>

            <div class="mt-4">
                <label for="photo">Ambil Foto</label>
                <input type="file" name="photo" id="photo" accept="image/*" capture="camera" required>
            </div>
        </form>

        <h4 class="mt-4">Riwayat Absensi</h4>
        <table class="table">
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
            @foreach($absensi as $a)
            <tr>
                <td>{{ $a->time }}</td>
                <td>{{ ucfirst($a->status) }}</td>
                <td>
                    @if($a->photo)
                        <img src="{{ asset('storage/' . $a->photo) }}" alt="Foto Absensi" class="w-20 h-20 object-cover">
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>