kok gak ada nampilin preview nya yg posisinya di live camera tapi freze karena sudah ambil foto
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
                        background: "#86efac", 
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

        <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
            <h4 class="font-semibold text-lg text-blue-800 mb-2">📍 Lokasi Anda:</h4>
            <p id="location" class="text-blue-600 font-medium">Sedang mengambil lokasi...</p>
            <div id="map" class="w-full h-64 rounded-lg border"></div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8">
            <form id="absensiForm" action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <div class="flex gap-6">
                    <button type="button" onclick="startAbsen('masuk')" 
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold text-2xl py-6 px-8 rounded-xl transition shadow-lg">
                        ✅ Absen Masuk
                    </button>
                    <button type="button" onclick="startAbsen('pulang')" 
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold text-2xl py-6 px-8 rounded-xl transition shadow-lg">
                        🚪 Absen Pulang
                    </button>
                </div>

                <div id="cameraSection" class="hidden space-y-3">
                    <label class="block font-medium text-gray-700 dark:text-gray-300 text-lg">
                        📸 Kamera
                    </label>

                    <div class="relative w-full">
                        <video id="video" autoplay playsinline
                            class="w-full rounded-xl border shadow bg-black"></video>

                        <img id="preview"
                            class="absolute inset-0 w-full h-full object-cover rounded-xl hidden">
                    </div>

                    <canvas id="canvas" class="hidden"></canvas>

                    <button type="button" onclick="capturePhoto()"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl">
                        📷 Ambil Foto
                    </button>
                    
                    <input type="file" name="photo" id="photo" class="hidden" required>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200 mb-4">📜 Riwayat Absensi</h4>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Jam</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Foto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($absensi as $a)
                        <tr>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($a->time)->timezone('Asia/Makassar')->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($a->time)->timezone('Asia/Makassar')->format('H:i:s') }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $absensi->links() }}
            </div>
        </div>

    <script>
        const officeLat = {{ $officeLat }};
        const officeLng = {{ $officeLng }};
        const maxRadius = {{ $maxRadius }};

        console.log({
            officeLat,
            officeLng,
            maxRadius
        });

    </script>

    <script>
        let map;
        let marker;
        let stream = null;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    document.getElementById("location").innerHTML =
                        `Latitude: ${lat}<br>Longitude: ${lng}`;

                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;

                    map = L.map('map').setView([lat, lng], 16);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    }).addTo(map);
                    
                    marker = L.marker([lat, lng]).addTo(map)
                        .bindPopup("📍 Lokasi Anda")
                        .openPopup();

                    L.circle([officeLat, officeLng], {
                        radius: maxRadius,
                        color: 'red',
                        fillOpacity: 0.2
                    }).addTo(map).bindPopup("Area Absensi");
                },

                function (error) {
                    document.getElementById("location").innerHTML =
                        "⚠️ Gagal mengambil lokasi. Pastikan GPS aktif & izin diberikan.";
                    console.error(error);
                },
                {
                    enableHighAccuracy: true
                }
            );
        } else {
            document.getElementById("location").innerHTML =
                "❌ Browser tidak mendukung Geolocation.";
        }
    </script>

    <script>
        function setLocation() {
            if (document.getElementById("latitude").value && document.getElementById("longitude").value) {
                return true; 
            } else {
                alert("Lokasi belum berhasil diambil. Coba lagi.");
                return false;
            }
        }

        function confirmAbsen(status) {
            let message = status === "masuk" 
                ? "Apakah Anda yakin ingin ABSEN MASUK?" 
                : "Apakah Anda yakin ingin ABSEN PULANG?";
            let bgColor = status === "masuk" ? "#86efac" : "#fca5a5"; 

            Swal.fire({
                title: message,
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                color: "#000", 
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
                        return; 
                    }

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
                        return; 
                    }

                    let form = document.getElementById('absensiForm');
                    let hiddenStatus = document.createElement("input");
                    hiddenStatus.type = "hidden";
                    hiddenStatus.name = "status";
                    hiddenStatus.value = status;
                    form.appendChild(hiddenStatus);

                    const distance = calculateDistance(lat, lng, officeLat, officeLng);
                    if (distance > maxRadius) {
                        Swal.fire({
                            title: "Di Luar Area Kantor",
                            text: `Anda berada ± ${Math.round(distance)} meter dari kantor`,
                            icon: "error",
                            confirmButtonText: "OK",
                            background: "#fecaca",
                            color: "#000"
                        });
                        return;
                    }

                    form.submit();
                }
            });
        }
    </script>

    <!-- Check user location in radius to present -->
    <script>
        function toRad(value) {
            return value * Math.PI / 180;
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371000; // meter
            const dLat = toRad(lat2 - lat1);
            const dLon = toRad(lon2 - lon1);

            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }
    </script>

    <!-- Activing Camera -->
     <script>
        let video = document.getElementById('video');
        let canvas = document.getElementById('canvas');
        let preview = document.getElementById('preview');
    </script>

    <!-- entry Absen -->
    <script>
        let selectedStatus = null;

        function startAbsen(status) {
            selectedStatus = status;

            document.getElementById('cameraSection').classList.remove('hidden');

            navigator.mediaDevices.getUserMedia({
                video: { facingMode: "user" }
            })
            .then(s => {
                stream = s;
                video.srcObject = stream;
            })
            .catch(err => {
                Swal.fire("Error", "Tidak bisa mengakses kamera", "error");
                console.error(err);
            });

            Swal.fire({
                title: 'Ambil Foto',
                text: 'Pastikan wajah terlihat jelas',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>

    <!-- Capture Photo -->
     <script>
        function capturePhoto() {
            const context = canvas.getContext('2d');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            context.drawImage(video, 0, 0);

            canvas.toBlob(blob => {
                const file = new File([blob], "absensi.jpg", {
                    type: "image/jpeg"
                });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('photo').files = dataTransfer.files;

                preview.src = URL.createObjectURL(blob);
                preview.classList.remove('hidden');

                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }

                Swal.fire({
                icon: 'success',
                title: 'Foto berhasil diambil',
                text: 'Lanjutkan absensi?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Ambil Ulang',
            }).then(result => {
                if (result.isConfirmed) {
                    confirmSubmit();
                } else {
                    preview.classList.add('hidden');
                    navigator.mediaDevices.getUserMedia({
                        video: { facingMode: "user" }
                    }).then(s => {
                        stream = s;
                        video.srcObject = stream;
                    });
                }
            });
            }, 'image/jpeg', 0.95);
        }
    </script>

    <!-- Confirm Submit Absen -->
    <script>
        function confirmSubmit() {
            let message = selectedStatus === "masuk"
                ? "Apakah Anda yakin ingin ABSEN MASUK?"
                : "Apakah Anda yakin ingin ABSEN PULANG?";

            Swal.fire({
                title: message,
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    submitAbsen();
                }
            });
        }

        function submitAbsen() {
            let form = document.getElementById('absensiForm');

            let hiddenStatus = document.createElement("input");
            hiddenStatus.type = "hidden";
            hiddenStatus.name = "status";
            hiddenStatus.value = selectedStatus;
            form.appendChild(hiddenStatus);

            form.submit();
        }
    </script>

</x-app-layout>
