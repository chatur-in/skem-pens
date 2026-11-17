<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Data prodi, departemen, dan mahasiswa contoh
        $this->call(SkemInitialSeeder::class);

        // Akun admin (dari ADMIN_EMAIL / ADMIN_PASSWORD di .env)
        $this->call(AdminSeeder::class);
    }
}