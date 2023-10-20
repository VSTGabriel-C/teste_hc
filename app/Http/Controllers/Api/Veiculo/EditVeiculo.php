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
        $response = null;

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

}
