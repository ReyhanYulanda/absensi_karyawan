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

        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <button type="submit" name="status" value="masuk" class="btn btn-success">Absen Masuk</button>
            <button type="submit" name="status" value="pulang" class="btn btn-danger">Absen Pulang</button>
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
            </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>

