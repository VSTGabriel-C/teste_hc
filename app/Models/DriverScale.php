<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverScale extends Model
{
    protected $fillable = ['fk_scale', 'fk_driver', 'hour_mot'];

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
