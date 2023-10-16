<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scale extends Model
{
    protected $fillable = ['identification', 'date_start', 'hour_start', 'hour_end', 'save', 'active'];

    public function vehicleScales()
    {
        return $this->hasMany(VehicleScale::class);
    }

    public function driverScales()
    {
        return $this->hasMany(DriverScale::class);
    }
}
