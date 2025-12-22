<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('license_plate')->unique();
            $table->foreignId('category_id')->constrained('fleet_categories')->onDelete('cascade');
            $table->string('capacity');
            $table->string('image')->nullable();
            $table->enum('current_status', ['unassigned', 'assigned', 'en_route', 'completed'])->default('unassigned');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};