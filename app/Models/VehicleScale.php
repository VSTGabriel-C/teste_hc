<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleScale extends Model
{
    protected $fillable = ['fk_scale', 'fk_vehicle', 'fk_driver'];

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
