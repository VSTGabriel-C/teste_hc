<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['type', 'pref', 'plate', 'brend', 'status', 'h_d', 'motive', 'email'];

    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }

    public function vehicleScales()
    {
        return $this->hasMany(VehicleScale::class);
    }
}
