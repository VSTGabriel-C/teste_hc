<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'status', 'h_d', 'motive'];

    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }

    public function driverScales()
    {
        return $this->hasMany(DriverScale::class);
    }
}
