<?php

namespace App\Models; // ✅ Harus ini

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;   // Tambahkan ini
use App\Models\Fleet; // Tambahkan ini

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'fleet_id',
        'task_number',
        'origin',
        'destination',
        'cargo_type',
        'cargo_volume',
        'vehicle_plate',
        'operating_cost',
        'status',
    ];

    protected $casts = [
        'operating_cost' => 'decimal:2',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class, 'fleet_id');
    }

    public static function generateTaskNumber(): string
    {
        return 'TASK-' . now()->format('ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}