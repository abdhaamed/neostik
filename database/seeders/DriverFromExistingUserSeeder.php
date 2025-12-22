<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Driver;

class DriverFromExistingUserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user dengan role driver yang belum punya driver record
        $driverUsers = User::where('role', 'driver')
            ->doesntHave('driver')
            ->get();

        foreach ($driverUsers as $user) {
            Driver::create([
                'user_id' => $user->id,
                'driver_code' => 'DRV-' . strtoupper(substr(md5($user->id . time()), 0, 6)),
                'rating' => 0.00,
                'total_completed' => 0,
                'availability' => 'available',
                'current_status' => 'no_task',
            ]);
        }

        $this->command->info('Driver records created for existing driver users!');
    }
}