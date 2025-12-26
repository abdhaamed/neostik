<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('fleet_id')->constrained('fleets')->onDelete('cascade');
            $table->string('task_number')->unique();
            $table->text('origin');
            $table->text('destination');
            $table->string('cargo_type')->nullable();
            $table->string('cargo_volume')->nullable();
            $table->string('vehicle_plate')->nullable();
            $table->decimal('operating_cost', 12, 2)->nullable();
            $table->enum('status', ['assigned', 'en_route', 'completed', 'cancelled'])->default('assigned');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};