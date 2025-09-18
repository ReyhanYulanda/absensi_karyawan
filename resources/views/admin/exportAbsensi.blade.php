<table>
    <thead>
        <tr>
            <th>Nama Karyawan</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensi as $a)
            <tr>
                <td>{{ $a->user->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($a->time)->timezone('Asia/Makassar')->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($a->time)->timezone('Asia/Makassar')->format('H:i:s') }}</td>
                <td>{{ ucfirst($a->status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
