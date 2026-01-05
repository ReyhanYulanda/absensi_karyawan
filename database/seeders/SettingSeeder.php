<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::insert([
            ['key' => 'app_name', 'value' => 'Absensi UMKM'],
            ['key' => 'app_logo', 'value' => 'logos/logo.png'],
            ['key' => 'app_favicon', 'value' => 'logos/favicon.ico'],
        ]);
    }
}
