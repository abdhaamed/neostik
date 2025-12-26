<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('device_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->timestamp('event_timestamp');
            $table->string('event_type'); // e.g. "Device Moving", "Engine Started", "Device Idle"
            $table->text('location')->nullable();
            $table->enum('status', ['Active', 'Started', 'Idle', 'Stopped', 'Connected', 'Disconnected']);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_histories');
    }
};