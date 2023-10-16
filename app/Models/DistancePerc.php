<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistancePerc extends Model
{
    protected $fillable = ['fk_dir_going', 'fk_dir_return', 'fk_dir_ch'];

    public function dirGoing()
    {
        return $this->belongsTo(DirGoing::class);
    }

    public function dirReturn()
    {
        return $this->belongsTo(DirReturn::class);
    }

    public function dirCh()
    {
        return $this->belongsTo(DirCh::class);
    }
}
