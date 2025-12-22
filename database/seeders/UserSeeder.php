<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN (Filament + Dashboard Admin)
        User::firstOrCreate(
            ['email' => 'admin@system.test'],
            [
                'name' => 'Admin System',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // DRIVER / USER
        User::firstOrCreate(
            ['email' => 'driver@system.test'],
            [
                'name' => 'Driver System',
                'password' => Hash::make('password'),
                'role' => 'driver',
            ]
        );
    }
}
