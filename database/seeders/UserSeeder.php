<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Perpustakaan',
            'email'    => 'admin@perpustakaan.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Anggota contoh
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@example.com',
            'password' => Hash::make('password'),
            'role'     => 'anggota',
        ]);

        User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@example.com',
            'password' => Hash::make('password'),
            'role'     => 'anggota',
        ]);
    }
}