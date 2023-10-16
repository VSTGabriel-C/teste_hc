<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ramal extends Model
{
    protected $fillable = ['n_ramal', 'applicant_id'];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
