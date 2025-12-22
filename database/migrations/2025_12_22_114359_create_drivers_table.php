<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('driver_code')->unique();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_completed')->default(0);
            $table->enum('availability', ['available', 'on_leave'])->default('available');
            $table->enum('current_status', ['no_task', 'assigned', 'en_route'])->default('no_task');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};