<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distancia_perc extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'km',
        'fk_saida',
        'fk_volta',
        'fk_chegada'
    ];
}
