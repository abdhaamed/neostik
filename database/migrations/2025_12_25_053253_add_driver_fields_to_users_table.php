<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom 'role' sudah ada, jika belum tambahkan
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'driver'])->default('driver')->after('password');
            }
            
            $table->string('driver_id')->unique()->nullable()->after('id');
            $table->string('phone')->nullable()->after('email');
            $table->string('license_number')->nullable()->after('phone');
            $table->string('vehicle_type')->nullable()->after('license_number');
            $table->string('vehicle_plate')->nullable()->after('vehicle_type');
            $table->string('address')->nullable()->after('vehicle_plate');
            $table->date('date_of_birth')->nullable()->after('address');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('role');
            $table->enum('availability', ['available', 'on_duty', 'on_leave'])->default('available')->after('status');
            $table->decimal('rating', 2, 1)->default(0)->after('availability');
            $table->integer('completed_deliveries')->default(0)->after('rating');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'driver_id',
                'phone',
                'license_number',
                'vehicle_type',
                'vehicle_plate',
                'address',
                'date_of_birth',
                'status',
                'availability',
                'rating',
                'completed_deliveries'
            ]);
            // Jangan drop 'role' karena ada di migration terpisah
        });
    }
};