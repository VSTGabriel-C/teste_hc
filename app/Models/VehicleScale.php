<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class VehicleScale extends Model
{
    protected $fillable = ['fk_scale', 'fk_vehicle', 'fk_driver'];

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

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
                    $mot_veic_n = VehicleScale::find($observacao_veic);

                    if ($mot_veic_n)
                    {
                        $mot_veic_n -> observation =  $observacoes[$i];
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
                            $veiculo_n = new VehicleScale();
                            if ($veiculo_i === end($veiculo)) {
                                $veiculo_n->observation = $observacoes[$i];
                            }
                            $veiculo_n ->fk_scale = $id_escala;
                            $veiculo_n ->fk_driver = $motoristas[$i];

                            $veiculo_n ->fk_vehicle = $veiculo_i;

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
