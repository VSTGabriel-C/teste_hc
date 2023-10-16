<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = ['matriculation', 'ramal', 'name', 'email', 'h_d', 'motive'];

    public function ramals()
    {
        return $this->hasMany(Ramal::class);
    }

    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }
}
