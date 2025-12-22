<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FleetCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relasi ke Fleets
    public function fleets()
    {
        return $this->hasMany(Fleet::class, 'category_id');
    }
}
