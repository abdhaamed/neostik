<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FleetStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'fleet_id',
        'task_id',
        'status',
        'recipient',
        'description',
        'report_image',
        'uploaded_by',
    ];

    // Relasi ke Fleet
    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Relasi ke Uploader (User)
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}