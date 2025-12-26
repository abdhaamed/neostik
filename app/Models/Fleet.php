<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    use HasFactory;

    protected $fillable = [
        'fleet_id',
        'status',
        'image',
        'weight',
        'unassigned_recipient',
        'unassigned_description',
        'unassigned_report',
        'assigned_recipient',
        'assigned_description',
        'assigned_report',
        'enroute_recipient',
        'enroute_description',
        'enroute_report',
        'completed_recipient',
        'completed_description',
        'completed_report',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    // Relationship: Fleet has one Device
    public function device()
    {
        return $this->hasOne(Device::class);
    }

    // Helper method to get bukti operasional by status
    public function getBuktiOperasional()
    {
        return [
            [
                'status' => 'Unassigned',
                'recipient' => $this->unassigned_recipient,
                'description' => $this->unassigned_description,
                'report' => $this->unassigned_report,
            ],
            [
                'status' => 'Assigned',
                'recipient' => $this->assigned_recipient,
                'description' => $this->assigned_description,
                'report' => $this->assigned_report,
            ],
            [
                'status' => 'En Route',
                'recipient' => $this->enroute_recipient,
                'description' => $this->enroute_description,
                'report' => $this->enroute_report,
            ],
            [
                'status' => 'Completed',
                'recipient' => $this->completed_recipient,
                'description' => $this->completed_description,
                'report' => $this->completed_report,
            ],
        ];
    }
}