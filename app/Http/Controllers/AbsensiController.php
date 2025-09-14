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
        $absensi = Absensi::where('user_id', Auth::id())->latest()->get();
        return view('karyawan.index', compact('absensi'));
    }

    public function store(Request $request, ImageService $imageService)
    {
        $request->validate([
            'status' => 'required|in:masuk,pulang',
            'photo' => 'required|mimes:jpeg,jpg,png,webp|max:10240', 
        ]);

        $photo = $request->file('photo');
        $filename = time().'_'.$photo->getClientOriginalName();
        $path = $imageService->compressAndSave($photo, $filename);

        Absensi::create([
            'user_id' => Auth::id(),
            'status' => $request->status,
            'time' => now(),
            'photo' => $path
        ]);

        return redirect()->back()->with('success', 'Absen berhasil tercatat!');
    }
}

