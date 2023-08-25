<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ch_destino extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "horario"
    ];
}
