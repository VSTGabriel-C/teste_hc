<?php

namespace App\Http\Controllers\Api\Veiculo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EditVeiculo extends Controller
{
    public function editVeiculo(Request $request)
    {
        $id = $request->id;
        $pref = $request->pref;
        $tipo = $request->tipo;
        $placa = $request->placa;
        $marca = $request->marca;

        $st = DB::update("UPDATE `veiculo`
        SET `tipo` = :tipo,
        `pref` = :pref,
        `placa` = :placa,
        `marca` = :marca
        WHERE `veiculo`.`id` = :id",[
            ":id" => $id,
            ":tipo" => $tipo,
            ":pref" => $pref,
            ":placa" => $placa,
            ":marca" => $marca
        ]);
        if($st)
        {
            return json_encode($response = [
                'status' => 1,
                'msg' => "Veiculo editado com sucesso"
            ]);
        }else
        {
            return json_encode($response = [
                'status' => 0,
                'msg' => "Erro ao editar Veiculo"
            ]);
        }
        return json_encode($response);

    }

    public function getVeiculoById(Request $request, $id)
    {
        $response = DB::select('SELECT
        v.id,
        v.marca,
        v.placa,
        v.pref,
        v.tipo
        FROM veiculo
        AS v
        WHERE id = :id', [':id' => $id]);

        return json_encode($response);
    }

    public function getVeiculoDisponivel()
    {
        $var = DB::select("SELECT
        *
        FROM veiculo v
        WHERE v.status = 1");

        return json_encode($var);
    }
    public function getVeiculoHabilitado()
    {
        $var = DB::select("SELECT
        *
        FROM veiculo v
        WHERE v.h_d = 1");

        return json_encode($var);
    }
}
