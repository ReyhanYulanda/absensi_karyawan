<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        Absensi::create([
            'user_id' => Auth::id(),
            'status' => $request->status,
            'time' => now()
        ]);

        return redirect()->back()->with('success', 'Absen berhasil tercatat!');
    }
}

