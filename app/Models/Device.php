<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'fleet_id',
        'device_code',
        'imei_number',
        'sim_card_number',
        'connection_status',
        'signal_strength',
        'last_update',
    ];

    protected $casts = [
        'last_update' => 'datetime',
    ];

    // Relasi ke Fleet
    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    // Relasi ke Device Activity Logs
    public function activityLogs()
    {
        return $this->hasMany(DeviceActivityLog::class);
    }

    // Relasi ke GPS Logs
    public function gpsLogs()
    {
        return $this->hasMany(GpsLog::class);
    }
}