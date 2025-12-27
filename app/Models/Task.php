<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'accepted_by_admin',
        'accepted_at',
        'accepted_by',
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
        $datePrefix = now()->format('Ymd');
        $latestTask = self::where('task_number', 'like', "TASK-{$datePrefix}-%")->latest()->first();
        $number = $latestTask ? intval(substr($latestTask->task_number, -3)) + 1 : 1;
        return "TASK-{$datePrefix}-" . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function acceptedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }
}
