<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverScale extends Model
{
    protected $fillable = ['scale_id', 'driver_id', 'hour_mot'];

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
