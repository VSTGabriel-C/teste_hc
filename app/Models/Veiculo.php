<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tipo',
        'pref',
        'placa',
        'marca',
        'status',
        'fk_v_utensilios',
        'fk_distancia_perc'
    ];
}
