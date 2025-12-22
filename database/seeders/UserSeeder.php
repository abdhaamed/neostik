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

        User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin456'),
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

        $drivers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@gmail.com'],
            ['name' => 'Andi Pratama', 'email' => 'andi@gmail.com'],
            ['name' => 'Rizky Maulana', 'email' => 'rizky@gmail.com'],
            ['name' => 'Dedi Saputra', 'email' => 'dedi@gmail.com'],
            ['name' => 'Agus Wijaya', 'email' => 'agus@gmail.com'],
            ['name' => 'Fajar Hidayat', 'email' => 'fajar@gmail.com'],
            ['name' => 'Ilham Nugroho', 'email' => 'ilham@gmail.com'],
            ['name' => 'Rian Kurniawan', 'email' => 'rian@gmail.com'],
            ['name' => 'Yoga Prasetya', 'email' => 'yoga@gmail.com'],
            ['name' => 'Arif Rahman', 'email' => 'arif@gmail.com'],
        ];

        foreach ($drivers as $driver) {
            User::firstOrCreate(
                ['email' => $driver['email']],
                [
                    'name' => $driver['name'],
                    'password' => Hash::make('driver123'),
                    'role' => 'driver',
                ]
            );
        }
    }
}
