<?php

namespace App\Http\Controllers\Api\Veiculo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NewVeiculo extends Controller
{
    public function newVeiculo(Request $request)
    {
        $pref = $request->pref;
        $placa = $request->placa;
        $tipo = $request->tipo;
        $marca = $request->marca;

        $check = DB::select('SELECT v.pref FROM veiculo as v where v.pref = :pref', [":pref" => $pref]);

        if(count($check) >= 1)
        {
            $apiResponse = [
                "status" => 0,
                "msg"    => "Já exite um veiculo com o codigo digitado!"
            ];

            return json_encode($apiResponse);
        }

        $response = DB::insert('INSERT INTO veiculo
                                (tipo, 
                                pref,
                                placa,
                                marca,
                                `status`,
                                h_d
                                ) 
                                VALUES (
                                :tipo, 
                                :pref,
                                :placa,
                                :marca,
                                :status,
                                :h_d
                                )', 
                                [   ":tipo"     => $tipo, 
                                    ":pref"     => $pref,
                                    ":placa"    => $placa,
                                    ":marca"    => $marca,
                                    ":status"   => 1,
                                    ":h_d"      => 1
                                ]);
        if($response)
        {
            $apiResponse = [
                "status" => 1,
                "msg"    => "Veiculo cadastrado com sucesso!"
            ];

            return json_encode($apiResponse);
        }else
        {
            $apiResponse = [
                "status" => 0,
                "msg"    => "Erro ao inserir novo veiculo!"
            ];

            return json_encode($apiResponse);
        }
 
    }


    
}
