<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="grid grid-cols-3 md:grid-cols-3 gap-6 mb-6">
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Karyawan</h1>
                <p class="text-gray-600 dark:text-gray-300">
                   {{ $jumlahKaryawan }}
                </p>
            </div>
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Departemen</h1>
                <p class="text-gray-600 dark:text-gray-300">
                   5
                </p>
            </div>
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ now()->format('H:i') }}</h1>
                <p class="text-gray-600 dark:text-gray-300">
                   {{ now()->format('d-m-Y') }}
                </p>
            </div>
        </div>

        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-200 text-center">
                Statistik Presensi Karyawan
                <span class="block text-2xl font-normal text-gray-500 dark:text-gray-400">
                    Januari 2025
                </span>
            </h2>
        
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                    <canvas id="attendanceChart" height="200"></canvas>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="grid grid-rows-3 text-3xl font-bold md:grid-rows-3 gap-4 text-center">
                        <div class="bg-green-100 dark:bg-green-100 rounded-xl shadow border-2 border-green-300 p-4">
                            <h1 class="text-green-600 dark:text-green-600 mb-4">Hadir</h1>
                            <p class="text-green-600 dark:text-green-600">
                                {{ $chartData['hadir'] }}
                            </p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-100 rounded-xl shadow border-2 border-yellow-300 p-4">
                            <h1 class="text-yellow-600 dark:text-yellow-600 mb-4">Telat</h1>
                            <p class="text-yellow-600 dark:text-yellow-600">
                                {{ $chartData['telat'] }}
                            </p>
                        </div>
                        <div class="bg-red-100 dark:bg-red-100 rounded-xl shadow border-2 border-red-300 p-4">
                            <h1 class="text-red-600 dark:text-red-600 mb-4">Alpha</h1>
                            <p class="text-red-600 dark:text-red-600">
                                {{ $chartData['alpha'] }}
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-rows-3 text-3xl font-bold md:grid-rows-3 gap-4 text-center">
                        <div class="bg-blue-100 dark:bg-blue-100 rounded-xl shadow border-2 border-blue-300 p-4">
                            <h1 class="text-blue-600 dark:text-blue-600 mb-4">Izin</h1>
                            <p class="text-blue-600 dark:text-blue-600">
                                {{ $chartData['izin'] }}
                            </p>
                        </div>
                        <div class="bg-violet-100 dark:bg-violet-100 rounded-xl shadow border-2 border-violet-300 p-4">
                            <h1 class="text-violet-600 dark:text-violet-600 mb-4">Sakit</h1>
                            <p class="text-violet-600 dark:text-violet-600">
                                {{ $chartData['sakit'] }}
                            </p>
                        </div>
                        <div class="bg-slate-100 dark:bg-slate-100 rounded-xl shadow border-2 border-slate-300 p-4">
                            <h1 class="text-slate-600 dark:text-slate-600 mb-4">Cuti</h1>
                            <p class="text-slate-600 dark:text-slate-600">
                                {{ $chartData['cuti'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row sm:flex-wrap sm:items-end gap-4" id="filterForm">
                <div class="flex flex-col">
                    <label for="user_id" class="font-semibold text-gray-700 dark:text-gray-300">Karyawan:</label>
                    <select name="user_id" id="user_id" 
                        class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">-- Semua --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="date_only" class="font-semibold text-gray-700 dark:text-gray-300">Tanggal:</label>
                    <input type="date" name="date_only" id="date_only" value="{{ request('date_only') }}"
                        class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div class="flex flex-col">
                    <label for="start_date" class="font-semibold text-gray-700 dark:text-gray-300">Dari:</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                        class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                </div>
                <div class="flex flex-col">
                    <label for="end_date" class="font-semibold text-gray-700 dark:text-gray-300">Sampai:</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                        class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                        Cari
                    </button>
                    @if(request('user_id') || request('date_only') || request('start_date') || request('end_date'))
                        <a href="{{ route('dashboard') }}" 
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow" id="resetBtn">
                            Reset
                        </a>
                    @endif
                    <a href="{{ route('absensi.export', request()->query()) }}" 
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
                        Download Excel
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2 text-left">Nama Karyawan</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Jam</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Foto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($absensi as $a)
                        <tr>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $a->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($a->time)->timezone('Asia/Makassar')->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($a->time)->timezone('Asia/Makassar')->format('H:i:s') }}
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $a->status === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if ($a->photo)
                                    <div x-data="{ open: false }">
                                        <img
                                            src="{{ asset('storage/' . $a->photo) }}"
                                            alt="Foto Absensi"
                                            class="w-16 h-16 rounded-lg object-cover shadow cursor-pointer"
                                            @click="open = true"
                                        >

                                        <div
                                            x-show="open"
                                            x-transition
                                            class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
                                            @click.self="open = false"
                                        >
                                            <div class="bg-white p-4 rounded-xl max-w-xl">
                                                <img
                                                    src="{{ asset('storage/' . $a->photo) }}"
                                                    class="max-h-[80vh] rounded-lg"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                Tidak ada data absensi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $absensi->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const dateOnly = document.getElementById("date_only");
    const startDate = document.getElementById("start_date");
    const endDate = document.getElementById("end_date");
    const resetBtn = document.getElementById("resetBtn");

    function toggleInputs() {
        if (dateOnly.value) {
            startDate.disabled = true;
            endDate.disabled = true;
        } else if (startDate.value || endDate.value) {
            dateOnly.disabled = true;
        } else {
            dateOnly.disabled = false;
            startDate.disabled = false;
            endDate.disabled = false;
        }
    }

    document.addEventListener("DOMContentLoaded", toggleInputs);

    dateOnly.addEventListener("input", toggleInputs);
    startDate.addEventListener("input", toggleInputs);
    endDate.addEventListener("input", toggleInputs);

    if (resetBtn) {
        resetBtn.addEventListener("click", function() {
            dateOnly.disabled = false;
            startDate.disabled = false;
            endDate.disabled = false;
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('attendanceChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Hadir', 'Telat', 'Alpha', 'Izin', 'Sakit', 'Cuti'],
        datasets: [{
            data: [
                {{ $chartData['hadir'] }},
                {{ $chartData['telat'] }},
                {{ $chartData['alpha'] }},
                {{ $chartData['izin'] }},
                {{ $chartData['sakit'] }},
                {{ $chartData['cuti'] }}
            ],
            backgroundColor: [
                '#22c55e',
                '#fdcb35ff',
                '#ef4444',
                '#3b82f6',
                '#8b5cf6',
                '#64748b'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
