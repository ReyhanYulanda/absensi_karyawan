<?php

namespace App\Http\Controllers;

use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = setting::all();
        return view('admin.setting.viewSetting', compact('settings'));
    }

    public function create()
    {
        return view('admin.setting.createSetting');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:settings'],
            'value' => ['required', 'string', 'max:255'],
        ]);

        setting::create([
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return redirect(route('setting.index'))->with('success', 'Setting berhasil ditambahkan');
    }

    public function edit(setting $setting)
    {
        return view('admin.setting.editSetting', compact('setting'));
    }

    public function update(Request $request, setting $setting)
    {
        $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:settings,key,' . $setting->id],
            'value' => ['required', 'string', 'max:255'],
        ]);

        $setting->update([
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return redirect(route('setting.index'))->with('success', 'Setting berhasil diperbarui');
    }

    public function destroy(setting $setting)
    {
        $setting->delete();
        return redirect(route('setting.index'))->with('success', 'Setting berhasil dihapus');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $setting = Setting::firstOrCreate(
            ['key' => 'app_logo'],
            ['value' => '']
        );

        if ($setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }

        $path = $request->file('logo')->store('logos', 'public');

        $setting->update([
            'value' => $path,
        ]);

        return redirect()->back()->with('success', 'Logo berhasil diperbarui');
    }
}
