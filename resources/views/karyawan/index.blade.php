<x-app-layout>
    <x-slot name="header">
        <h1 class="font-bold text-2xl text-gray-800 dark:text-gray-200">
            {{ __('Absensi Karyawan') }}
        </h1>
    </x-slot>

    <div class="max-w-5xl mx-auto py-8 px-4">
        @if(session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "{{ session('success') }}",
                        icon: "success",
                        confirmButtonText: "OK",
                        color: "#000",
                        background: "#86efac", // hijau soft
                        confirmButtonColor: "#15803d",
                        width: "35em",
                        customClass: {
                            popup: "rounded-2xl shadow-2xl p-6",
                            title: "text-2xl font-bold"
                        }
                    });
                });
            </script>
        @endif

        <!-- Lokasi tampil di sini -->
        <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
            <h4 class="font-semibold text-lg text-blue-800 mb-2">📍 Lokasi Anda:</h4>
            <p id="location" class="text-blue-600 font-medium">Sedang mengambil lokasi...</p>
        </div>

        <!-- Form Absensi -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8">
            <form id="absensiForm" action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <div class="flex gap-6">
                    <button type="button" onclick="confirmAbsen('masuk')" 
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold text-2xl py-6 px-8 rounded-xl transition shadow-lg">
                        ✅ Absen Masuk
                    </button>
                    <button type="button" onclick="confirmAbsen('pulang')" 
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold text-2xl py-6 px-8 rounded-xl transition shadow-lg">
                        🚪 Absen Pulang
                    </button>
                </div>

                <div>
                    <label for="photo" class="block font-medium text-gray-700 dark:text-gray-300 mb-3 text-lg">📸 Ambil Foto</label>
                    <input type="file" name="photo" id="photo" accept="image/*" capture="camera" required
                        class="block w-full text-base text-gray-600 file:mr-4 file:py-3 file:px-6
                            file:rounded-lg file:border-0
                            file:text-base file:font-semibold
                            file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700 cursor-pointer">
                </div>
            </form>
        </div>

        <!-- Riwayat Absensi -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200 mb-4">📜 Riwayat Absensi</h4>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Foto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($absensi as $a)
                        <tr>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($a->time)->timezone('Asia/Makassar')->format('d-m-Y H:i:s') }}</td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $a->status === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if($a->photo)
                                    <img src="{{ asset('storage/' . $a->photo) }}" alt="Foto Absensi" class="w-20 h-20 rounded-lg object-cover shadow">
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $absensi->links() }}
            </div>
        </div>


    <script>
        // Tampilkan lokasi begitu halaman dibuka
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById("location").innerHTML =
                    "Latitude: " + position.coords.latitude +
                    "<br>Longitude: " + position.coords.longitude;

                // isi hidden input juga
                document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;

            }, function(error) {
                document.getElementById("location").innerHTML = "⚠️ Gagal mengambil lokasi. Pastikan GPS aktif & izin diberikan.";
                console.error(error);
            });
        } else {
            document.getElementById("location").innerHTML = "❌ Browser tidak mendukung Geolocation.";
        }

        // Set lokasi sebelum submit form
        function setLocation() {
            if (document.getElementById("latitude").value && document.getElementById("longitude").value) {
                return true; // lanjut submit form
            } else {
                alert("Lokasi belum berhasil diambil. Coba lagi.");
                return false;
            }
        }

        // Alert button
        function confirmAbsen(status) {
            let message = status === "masuk" 
                ? "Apakah Anda yakin ingin ABSEN MASUK?" 
                : "Apakah Anda yakin ingin ABSEN PULANG?";
            let bgColor = status === "masuk" ? "#86efac" : "#fca5a5"; // hijau / merah

            Swal.fire({
                title: message,
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                color: "#000", // teks hitam
                background: bgColor,
                confirmButtonColor: "#15803d",
                cancelButtonColor: "#6b7280",
                width: "40em",
                customClass: {
                    popup: "rounded-2xl shadow-2xl p-6",
                    title: "text-2xl font-bold"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let lat = document.getElementById("latitude").value;
                    let lng = document.getElementById("longitude").value;
                    let photo = document.getElementById("photo");

                    // 🔴 Validasi lokasi
                    if (!lat || !lng) {
                        Swal.fire({
                            title: "Gagal Absen",
                            text: "Lokasi tidak bisa didapatkan. Pastikan GPS aktif & izin diberikan.",
                            icon: "error",
                            confirmButtonText: "OK",
                            color: "#000",
                            background: "#FFEA99",
                            width: "35em",
                            customClass: {
                                popup: "rounded-2xl shadow-2xl p-6",
                                title: "text-xl font-bold"
                            }
                        });
                        return; // hentikan submit
                    }

                    // 🔴 Validasi foto
                    if (!photo.files.length) {
                        Swal.fire({
                            title: "Gagal Absen",
                            text: "Anda harus mengupload / mengambil foto sebelum absen.",
                            icon: "error",
                            confirmButtonText: "OK",
                            color: "#000",
                            background: "#FFEA99",
                            width: "35em",
                            customClass: {
                                popup: "rounded-2xl shadow-2xl p-6",
                                title: "text-xl font-bold"
                            }
                        });
                        return; // hentikan submit
                    }

                    // ✅ Kalau valid → submit form
                    let form = document.getElementById('absensiForm');
                    let hiddenStatus = document.createElement("input");
                    hiddenStatus.type = "hidden";
                    hiddenStatus.name = "status";
                    hiddenStatus.value = status;
                    form.appendChild(hiddenStatus);

                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>
