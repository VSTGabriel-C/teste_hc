<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirReturn extends Model
{
    protected $fillable = ['hour', 'km', 'warning_return', 'fk_solicitation'];

    public function solicitation()
    {
        return $this->belongsTo(Solicitation::class);
    }
}
