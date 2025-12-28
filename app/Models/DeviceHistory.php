<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'event_timestamp',
        'event_type',
        'location',
        'status',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'event_timestamp' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    // Relationship: History belongs to Device
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function getStatusColor()
    {
        $colors = [
            'Active' => 'green',
            'Started' => 'blue',
            'Idle' => 'yellow',
            'Stopped' => 'gray',
            'Connected' => 'green',
            'Disconnected' => 'red',
        ];
        
        return $colors[$this->status] ?? 'gray';
    }
}