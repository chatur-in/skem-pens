<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->error('ADMIN_EMAIL dan ADMIN_PASSWORD wajib diisi di .env');
            return;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = env('ADMIN_NAME', 'Admin SKEM');
        $user->password = $password; // otomatis di-hash oleh cast 'hashed'
        $user->forceFill(['is_admin' => true])->save();

        $this->command?->info("Akun admin siap: {$email}");
    }
}