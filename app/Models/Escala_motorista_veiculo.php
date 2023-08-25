<?php

namespace App\Models;

date_default_timezone_set('America/Sao_Paulo');

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escala_motorista_veiculo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        "id",
        "observacao",
        "fk_escala",
        "fk_motorista",
        "fk_veiculo",
    ];

    public $timestamps = false;

    public function editVeicEscala($escala)
    {
        $id_escala = $escala['fk_escala'];
        $motoristas = $escala['id_motorista'];
        $observacoes = $escala['observacoes'];
        $observacoes_veic = $escala['observacao_veic_fk'];
        if(!empty($observacoes_veic))
        {
            foreach ($observacoes_veic as $i => $observacao_veic)
            {
                try
                {
                    $mot_veic_n = Escala_motorista_veiculo::find($observacao_veic);

                    if ($mot_veic_n)
                    {
                        $mot_veic_n -> observacao =  $observacoes[$i];
                        $mot_veic_n -> date_update = now();

                        $mot_veic_n->save();
                    } else
                    {
                        return false;
                    }
                } catch (Exception $e)
                {
                    return false;

                }
            }
        }
        if(array_key_exists('new_veic', $escala))
        {

            foreach ($escala["new_veic"] as $i => $veiculo)
            {
                foreach ($veiculo as $v => $veiculo_i)
                {
                    if(!empty($veiculo))
                    {

                        try
                        {
                            $veiculo_n = new Escala_motorista_veiculo();
                            if ($veiculo_i === end($veiculo)) {
                                $veiculo_n->observacao = $observacoes[$i];
                            }
                            $veiculo_n ->fk_escala = $id_escala;
                            $veiculo_n ->fk_motorista = $motoristas[$i];

                            $veiculo_n ->fk_veiculo = $veiculo_i;

                            $veiculo_n ->date_insert = now();


                            $veiculo_n->save();
                        } catch (\Exception $e) {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }
}
