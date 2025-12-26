<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    protected $fillable = ['fleet_id', 'status', 'image'];

    protected $hidden = ['created_at', 'updated_at'];

    public function device()
    {
        return $this->hasOne(Device::class);
    }

    // Helper URL image
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/fleets/' . $this->image)
            : asset('images/truck-placeholder.png');
    }
}
