<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Driver;
use App\Models\FleetCategory;
use App\Models\Fleet;
use App\Models\Device;
use App\Models\Task;

class CompleteSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CREATE USERS (ADMIN & DRIVERS)
        $admin = User::firstOrCreate(
            ['email' => 'admin@system.test'],
            [
                'name' => 'Admin System',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $driverUsers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@gmail.com'],
            ['name' => 'Andi Pratama', 'email' => 'andi@gmail.com'],
            ['name' => 'Rizky Maulana', 'email' => 'rizky@gmail.com'],
            ['name' => 'Dedi Saputra', 'email' => 'dedi@gmail.com'],
            ['name' => 'Agus Wijaya', 'email' => 'agus@gmail.com'],
        ];

        $createdDriverUsers = [];
        foreach ($driverUsers as $driverData) {
            $user = User::firstOrCreate(
                ['email' => $driverData['email']],
                [
                    'name' => $driverData['name'],
                    'password' => Hash::make('driver123'),
                    'role' => 'driver',
                ]
            );
            $createdDriverUsers[] = $user;
        }

        // 2. CREATE DRIVER PROFILES
        $drivers = [];
        foreach ($createdDriverUsers as $index => $user) {
            $driver = Driver::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'driver_code' => 'DRV' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'rating' => rand(40, 50) / 10,
                    'total_completed' => rand(0, 50),
                    'availability' => 'available',
                    'current_status' => 'no_task',
                ]
            );
            $drivers[] = $driver;
        }

        // 3. CREATE FLEET CATEGORIES
        $categories = [
            ['name' => 'Truck'],
            ['name' => 'Van'],
            ['name' => 'Pickup'],
            ['name' => 'Container'],
        ];

        $fleetCategories = [];
        foreach ($categories as $category) {
            $fleetCategories[] = FleetCategory::firstOrCreate($category);
        }

        // 4. CREATE FLEETS
        $fleets = [];
        $licensePlates = ['B1234XYZ', 'B5678ABC', 'B9012DEF', 'B3456GHI', 'B7890JKL', 
                          'B2468MNO', 'B1357PQR', 'B8642STU', 'B9753VWX', 'B1590YZA'];
        
        foreach ($licensePlates as $index => $plate) {
            $fleet = Fleet::firstOrCreate(
                ['license_plate' => $plate],
                [
                    'serial_number' => 'FLT' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                    'category_id' => $fleetCategories[array_rand($fleetCategories)]->id,
                    'capacity' => rand(1000, 5000) . ' kg',
                    'current_status' => 'unassigned',
                ]
            );
            $fleets[] = $fleet;

            // CREATE DEVICE FOR FLEET
            Device::firstOrCreate(
                ['fleet_id' => $fleet->id],
                [
                    'device_code' => 'DEV' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                    'imei_number' => '86' . rand(1000000000000, 9999999999999),
                    'sim_card_number' => '08' . rand(10000000000, 99999999999),
                    'connection_status' => rand(0, 1) ? 'connected' : 'disconnected',
                    'signal_strength' => rand(1, 5) . ' bars',
                    'last_update' => now()->subMinutes(rand(1, 60)),
                ]
            );
        }

        // 5. CREATE TASKS (AVAILABLE & ASSIGNED)
        $origins = ['Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Medan'];
        $destinations = ['Yogyakarta', 'Malang', 'Solo', 'Bali', 'Makassar'];
        $goodsTypes = ['Electronics', 'Furniture', 'Food Products', 'Textiles', 'Chemicals', 'Construction Materials'];

        // Create 15 AVAILABLE tasks (no driver assigned)
        for ($i = 0; $i < 15; $i++) {
            Task::create([
                'task_number' => 'TSK' . now()->format('Ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'driver_id' => null, // No driver assigned yet
                'fleet_id' => $fleets[array_rand($fleets)]->id,
                'delivery_date' => now()->addDays(rand(1, 14)),
                'origin' => $origins[array_rand($origins)],
                'destination' => $destinations[array_rand($destinations)],
                'goods_type' => $goodsTypes[array_rand($goodsTypes)],
                'status' => 'pending', // Available for drivers to claim
                'created_by' => $admin->id,
            ]);
        }

        // Create 5 ASSIGNED tasks (already claimed by drivers)
        for ($i = 15; $i < 20; $i++) {
            $assignedDriver = $drivers[array_rand($drivers)];
            $assignedFleet = $fleets[array_rand($fleets)];

            Task::create([
                'task_number' => 'TSK' . now()->format('Ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'driver_id' => $assignedDriver->id,
                'fleet_id' => $assignedFleet->id,
                'delivery_date' => now()->addDays(rand(0, 7)),
                'origin' => $origins[array_rand($origins)],
                'destination' => $destinations[array_rand($destinations)],
                'goods_type' => $goodsTypes[array_rand($goodsTypes)],
                'status' => rand(0, 1) ? 'assigned' : 'approved', // Some already started
                'created_by' => $admin->id,
            ]);

            // Update driver status
            $assignedDriver->update([
                'current_status' => 'assigned'
            ]);

            // Update fleet status
            $assignedFleet->update([
                'current_status' => 'assigned'
            ]);
        }

        // Create 3 COMPLETED tasks
        for ($i = 20; $i < 23; $i++) {
            $completedDriver = $drivers[array_rand($drivers)];

            Task::create([
                'task_number' => 'TSK' . now()->subDays(rand(1, 5))->format('Ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'driver_id' => $completedDriver->id,
                'fleet_id' => $fleets[array_rand($fleets)]->id,
                'delivery_date' => now()->subDays(rand(1, 5)),
                'origin' => $origins[array_rand($origins)],
                'destination' => $destinations[array_rand($destinations)],
                'goods_type' => $goodsTypes[array_rand($goodsTypes)],
                'status' => 'completed',
                'created_by' => $admin->id,
            ]);
        }

        $this->command->info('✅ Complete seeder finished!');
        $this->command->info('📧 Admin: admin@system.test | password: password');
        $this->command->info('📧 Driver: budi@gmail.com | password: driver123');
        $this->command->info('📦 Created: ' . Task::whereNull('driver_id')->count() . ' available tasks');
        $this->command->info('🚚 Created: ' . Task::whereNotNull('driver_id')->whereIn('status', ['assigned', 'approved'])->count() . ' assigned tasks');
    }
}