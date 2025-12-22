<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'event',
        'location',
        'latitude',
        'longitude',
        'speed',
        'status',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relasi ke Device
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}