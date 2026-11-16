<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (empty($email) || empty($password)) {
            throw new \RuntimeException(
                'ADMIN_EMAIL dan ADMIN_PASSWORD harus diisi di file .env'
            );
        }

        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make($password),
            ]
        );

        $admin->syncRoles(['admin']);
    }
}
