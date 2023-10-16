<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirCh extends Model
{
    protected $fillable = ['hour', 'km', 'warning_ch', 'solicitation_id'];

    public function solicitation()
    {
        return $this->belongsTo(Solicitation::class);
    }
}
