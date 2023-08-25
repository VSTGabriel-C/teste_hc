<?php

namespace App\Models;
date_default_timezone_set('America/Sao_Paulo');

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escala_motorista extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        "horario_mot",
        "fk_escala",
        "fk_motorista"
    ];

    public $timestamps = false;

    public function editMotoEscala($escala)
    {
        $ids_escala_motoristas = $escala['horario_mot_fk'];
        $horarios_edicao = $escala['horario_mot'];

        foreach ($ids_escala_motoristas as $i => $id_escala_motorista)
        {
            $escala_motorista = Escala_motorista::find($id_escala_motorista);
            if ($escala_motorista)
            {
                if($escala_motorista->horario_mot != $horarios_edicao[$i])
                {
                    try
                    {
                        $horario_mot = strval($horarios_edicao[$i]);

                        $update = Escala_motorista::where('id', $id_escala_motorista)
                        ->update([
                                            'horario_mot' => $horario_mot,
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
