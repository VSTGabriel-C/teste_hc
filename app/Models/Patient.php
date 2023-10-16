<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['patient_name'];

    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }
}
