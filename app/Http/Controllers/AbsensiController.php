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
                ->paginate(5);
                
        return view('karyawan.index', compact('absensi'));
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
            // ✅ Default tampilkan absensi hari ini kalau tidak ada filter sama sekali
            ->when(!$request->date_only && !$request->start_date && !$request->end_date, fn($q) => 
                $q->whereDate('time', now()->timezone('Asia/Makassar')->toDateString()))
            ->latest()
            ->paginate(10);

        $users = \App\Models\User::orderBy('name')->get();

        return view('dashboard', compact('absensi', 'users'));
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

