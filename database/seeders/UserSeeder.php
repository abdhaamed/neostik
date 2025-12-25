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
                'status' => 'active',
            ]
        );

        // SAMPLE DRIVERS with complete data
        $drivers = [
            [
                'driver_id' => 'DRV-012389217B',
                'name' => 'Davin Pratama',
                'email' => 'davin@driver.test',
                'password' => Hash::make('davin'),
                'phone' => '+62 812 3456 7890',
                'license_number' => 'LIC-098765',
                'vehicle_type' => 'Van',
                'vehicle_plate' => 'B 1234 ABC',
                'address' => 'Jl. Sudirman No. 123, Jakarta',
                'date_of_birth' => '1990-05-15',
                'role' => 'driver',
                'status' => 'active',
                'availability' => 'on_duty',
                'rating' => 4.8,
                'completed_deliveries' => 103,
            ],
            [
                'driver_id' => 'DRV-082937485O',
                'name' => 'Hamid R.',
                'email' => 'hamid@driver.test',
                'password' => Hash::make('hamid'),
                'phone' => '+62 813 9876 5432',
                'license_number' => 'LIC-123456',
                'vehicle_type' => 'Truck',
                'vehicle_plate' => 'D 5678 XYZ',
                'address' => 'Jl. Gatot Subroto No. 45, Bandung',
                'date_of_birth' => '1988-08-20',
                'role' => 'driver',
                'status' => 'active',
                'availability' => 'on_leave',
                'rating' => 4.2,
                'completed_deliveries' => 40,
            ],
            [
                'driver_id' => 'DRV-907632785G',
                'name' => 'Budi Santoso',
                'email' => 'budi@driver.test',
                'password' => Hash::make('budi'),
                'phone' => '+62 821 5555 1234',
                'license_number' => 'LIC-789012',
                'vehicle_type' => 'Car',
                'vehicle_plate' => 'B 9876 DEF',
                'address' => 'Jl. Thamrin No. 78, Jakarta',
                'date_of_birth' => '1992-03-10',
                'role' => 'driver',
                'status' => 'active',
                'availability' => 'available',
                'rating' => 4.3,
                'completed_deliveries' => 29,
            ],
            [
                'driver_id' => 'DRV-091234789O',
                'name' => 'Ahmad K.',
                'email' => 'ahmad@driver.test',
                'password' => Hash::make('ahmad'),
                'phone' => '+62 822 4444 9876',
                'license_number' => 'LIC-345678',
                'vehicle_type' => 'Motorcycle',
                'vehicle_plate' => 'F 4321 GHI',
                'address' => 'Jl. Asia Afrika No. 90, Surabaya',
                'date_of_birth' => '1995-11-25',
                'role' => 'driver',
                'status' => 'active',
                'availability' => 'on_duty',
                'rating' => 3.9,
                'completed_deliveries' => 70,
            ],
        ];

        foreach ($drivers as $driver) {
            User::firstOrCreate(
                ['email' => $driver['email']],
                $driver
            );
        }
    }
}