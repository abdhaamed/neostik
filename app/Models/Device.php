<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['fleet_id', 'device_id', 'imei', 'sim_card'];
    protected $hidden = ['created_at', 'updated_at'];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }
}