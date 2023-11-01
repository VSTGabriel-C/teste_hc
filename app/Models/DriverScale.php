<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverScale extends Model
{
    protected $fillable = ['fk_scale', 'fk_driver', 'hour_mot'];

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function EditDriverScale($escala)
    {
        $ids_escala_motoristas = $escala['horario_mot_fk'];
        $horarios_edicao = $escala['horario_mot'];

        foreach ($ids_escala_motoristas as $i => $id_escala_motorista)
        {
            $escala_motorista = Escala_motorista::find($id_escala_motorista);
            if ($escala_motorista)
            {
                if($escala_motorista->hour_mot != $horarios_edicao[$i])
                {
                    try
                    {
                        $horario_mot = strval($horarios_edicao[$i]);

                        $update = Escala_motorista::where('id', $id_escala_motorista)
                        ->update([
                                            'hour_mot' => $horario_mot,
                                            'date_update' => now() // Use a função now() para obter a data e hora atual
                                        ]);
                    } catch (\Exception $e)
                    {
                        return false;
                    }
                }
            }
        }

        return true;

    }
}
