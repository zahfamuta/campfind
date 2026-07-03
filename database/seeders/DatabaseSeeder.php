<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat data contoh untuk Akun Mahasiswa
        User::create([
            'identity_number' => '251110099', // Sesuaikan dengan NIM yang kamu mau
            'name' => 'Zahfa Mutaharrifa',
            'email' => 'zahfa@example.com',
            'password' => Hash::make('password123'), // Ini password untuk login nanti
            'phone_number' => '081234567890',
            'role' => 'mahasiswa',
        ]);
    }
} 