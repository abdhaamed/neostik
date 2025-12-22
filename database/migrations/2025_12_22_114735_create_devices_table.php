<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_id')->constrained('fleets')->onDelete('cascade');
            $table->string('device_code')->unique();
            $table->string('imei_number')->unique();
            $table->string('sim_card_number')->nullable();
            $table->enum('connection_status', ['connected', 'disconnected'])->default('disconnected');
            $table->string('signal_strength')->nullable();
            $table->timestamp('last_update')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};