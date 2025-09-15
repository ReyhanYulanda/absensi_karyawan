<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;


class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::where('user_id', Auth::id())
                ->latest()
                ->paginate(5); // tampilkan 5 data per halaman
                
        return view('karyawan.index', compact('absensi'));
    }

    public function store(Request $request, ImageService $imageService)
    {
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
}

