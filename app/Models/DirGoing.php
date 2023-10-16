<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirGoing extends Model
{
    protected $fillable = ['hour', 'km', 'fk_solicitation'];

    public function solicitation()
    {
        return $this->belongsTo(Solicitation::class);
    }
}
