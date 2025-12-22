<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'amount',
        'payment_method',
        'receipt_image',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}