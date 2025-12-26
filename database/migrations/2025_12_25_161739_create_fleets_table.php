<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->string('fleet_id')->unique(); // e.g. HD-99671212
            $table->enum('status', ['Unassigned', 'Assigned', 'En Route', 'Completed'])->default('Unassigned');
            $table->string('image')->nullable(); // Truck image
            $table->unsignedInteger('weight')->nullable();
            
            // Bukti Operasional fields
            $table->string('unassigned_recipient')->nullable(); // e.g. "PIC Gudang"
            $table->text('unassigned_description')->nullable();
            $table->text('unassigned_report')->nullable();
            
            $table->string('assigned_recipient')->nullable(); // e.g. "Lead Logistic"
            $table->text('assigned_description')->nullable();
            $table->text('assigned_report')->nullable();
            
            $table->string('enroute_recipient')->nullable(); // e.g. "Davin Pratama"
            $table->text('enroute_description')->nullable();
            $table->text('enroute_report')->nullable();
            
            $table->string('completed_recipient')->nullable(); // e.g. "PT Sejahtera Selalu"
            $table->text('completed_description')->nullable();
            $table->text('completed_report')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};