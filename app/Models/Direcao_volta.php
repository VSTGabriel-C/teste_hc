<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direcao_volta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'status',
        'horario'
    ];
}
