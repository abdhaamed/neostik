<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'license_plate',
        'category_id',
        'capacity',
        'image',
        'current_status',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(FleetCategory::class);
    }

    // Relasi ke Device
    public function device()
    {
        return $this->hasOne(Device::class);
    }

    // Relasi ke Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relasi ke Fleet Status Logs
    public function statusLogs()
    {
        return $this->hasMany(FleetStatusLog::class);
    }
}
