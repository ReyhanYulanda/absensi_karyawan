<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AbsensiController extends Controller
{
    
    
    public function index()
    {
        $officeLat = (float) setting('place_latitude');
        $officeLng = (float) setting('place_longitude');
        $maxRadius = (int) setting('place_radius', 100);
        $absensi = Absensi::where('user_id', Auth::id())
                ->latest()
                ->paginate(5);
                
        return view('karyawan.index', [
        'absensi' => $absensi,
        'officeLat' => (float) setting('place_latitude'),
        'officeLng' => (float) setting('place_longitude'),
        'maxRadius' => (int) setting('place_radius'),
]);

    }

    public function adminIndex(Request $request)
    {
        $absensi = Absensi::with('user')
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->date_only, fn($q) => 
                $q->whereDate('time', $request->date_only))
            ->when(!$request->date_only && $request->start_date, fn($q) => 
                $q->whereDate('time', '>=', $request->start_date))
            ->when(!$request->date_only && $request->end_date, fn($q) => 
                $q->whereDate('time', '<=', $request->end_date))
            ->when(!$request->date_only && !$request->start_date && !$request->end_date, fn($q) => 
                $q->whereDate('time', now()->timezone('Asia/Makassar')->toDateString()))
            ->latest()
            ->paginate(10);

        $users = User::get();
        $jumlahKaryawan = User::where('role', '!=', 'admin')->count();

        $chartData = [
            'hadir' => 10,
            'telat' => 2,
            'alpha' => 1,
            'izin' => 1,
            'sakit' => 1,
            'cuti' => 3,
        ];

        return view('dashboard', compact('absensi', 'users', 'jumlahKaryawan', 'chartData'));
    }

    public function store(Request $request, ImageService $imageService)
    {
        $officeLat = (float) setting('place_latitude');
        $officeLng = (float) setting('place_longitude');
        $maxRadius = (int) setting('place_radius', 100);

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $officeLat,
            $officeLng
        );

        if ($distance > $maxRadius) {
            return redirect()->back()->withErrors([
                'location' => 'Anda berada di luar radius kantor.'
            ]);
        }

        $request->validate([
            'status' => 'required|in:masuk,pulang',
            'photo' => 'required|mimes:jpeg,jpg,png,webp|max:10240', 
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $photo = $request->file('photo');
        $filename = time().'_'.$photo->getClientOriginalName();
        $path = $imageService->compressAndSave($photo, $filename);

        Absensi::create([
            'user_id' => Auth::id(),
            'status' => $request->status,
            'time' => now(),
            'photo' => $path,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->back()->with('success', 'Absen berhasil tercatat!');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

}

