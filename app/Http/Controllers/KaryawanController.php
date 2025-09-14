<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;

class KaryawanController extends Controller
{
    public function index(): View
    {
        $users = User::all();
        return view('admin.viewKaryawan', compact('users'));
    }

    public function create(): View
    {
        return view('admin.createKaryawan');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'max:255'],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => true
        ]);

        return redirect(route('karyawan.index'))->with('success', 'Karyawan berhasil ditambahkan');
    }
}
