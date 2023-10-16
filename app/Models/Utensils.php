<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utensils extends Model
{
    protected $fillable = ['oxygen', 'obese', 'isolate', 'stretcher', 'isolation', 'death', 'uti', 'd_isolation'];

    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }
}
