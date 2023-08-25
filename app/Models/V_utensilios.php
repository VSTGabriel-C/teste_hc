<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_utensilios extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'oxigenio',
        'obeso',
        'isolete',
        'maca',
        'isolamento',
        'obito',
        'desc_isolamento'
    ];
}
