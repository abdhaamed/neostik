<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_number',
        'driver_id',
        'fleet_id',
        'delivery_date',
        'origin',
        'destination',
        'goods_type',
        'status',
        'created_by',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    // Relasi ke Driver
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    // Relasi ke Fleet
    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    // Relasi ke Creator (Admin)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke Task Documents
    public function documents()
    {
        return $this->hasMany(TaskDocument::class);
    }

    // Relasi ke Task Evidences
    public function evidences()
    {
        return $this->hasMany(TaskEvidence::class);
    }

    // Relasi ke Task Costs
    public function costs()
    {
        return $this->hasMany(TaskCost::class);
    }

    // Relasi ke Fleet Status Logs
    public function statusLogs()
    {
        return $this->hasMany(FleetStatusLog::class);
    }
}