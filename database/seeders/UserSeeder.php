<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => true,
        ]);
    }
}
