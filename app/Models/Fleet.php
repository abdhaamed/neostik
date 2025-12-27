<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Fleet extends Model
{
    use HasFactory;

    // ✅ Field yang BOLEH diisi oleh ADMIN (saat create/update fleet/device)
    protected $fillable = [
        'fleet_id',
        'status',
        'image',
        'weight',
    ];

    // ✅ Field tambahan yang hanya BOLEH diisi oleh DRIVER (via TaskController)
    protected $fillableByDriver = [
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

    public function device()
    {
        return $this->hasOne(Device::class);
    }

    // ✅ Method khusus untuk update bukti operasional (hanya dipanggil oleh TaskController)
    // app/Models/Fleet.php
    // app/Models/Fleet.php
    public function updateBuktiOperasional(array $data)
    {
        $allowed = array_intersect_key($data, array_flip($this->fillableByDriver));

        // ✅ Log data yang akan disimpan
        Log::info('Preparing to save bukti operasional', [
            'fleet_id' => $this->id,
            'data' => $allowed
        ]);

        // ✅ Simpan langsung kolom spesifik (bukan fill)
        foreach ($allowed as $key => $value) {
            $this->$key = $value;
        }

        // ✅ Force save dan refresh
        $saved = $this->save();

        if ($saved) {
            // ✅ Refresh model dari database untuk memastikan
            $this->refresh();
            Log::info('Bukti operasional saved and refreshed', [
                'fleet_id' => $this->id,
                'current_data' => $this->only(array_keys($allowed))
            ]);
        } else {
            Log::error('Failed to save bukti operasional', [
                'fleet_id' => $this->id,
                'data' => $allowed
            ]);
        }

        return $saved;
    }

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
