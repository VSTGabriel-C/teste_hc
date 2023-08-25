<?php

namespace App\Http\Controllers\Api\Veiculo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ExcludeVeiculo extends Controller
{
    public function excludeVeiculo(Request $request)
    {
        $id = $request->id;
        $motivo = $request->motivo;
        $new;

        $re = DB::select("SELECT v.h_d FROM veiculo v WHERE v.id = ?", [$id]);

        foreach ($re as $key)
        {
            $new = $key->h_d;
        }

        if($new == 2)
        {
            $st = DB::update("UPDATE veiculo v
            SET v.h_d = ?,
            v.motivo = ?,
            v.status = ?
            WHERE v.id = ?",
            [
                1,
                $motivo,
                1,
                $id,
            ]);

            if($st)
            {
                return json_encode($response = array(
                    'status' => 1,
                    'msg' => "Veiculo habilitado com sucesso!"
                ));
            }
            else
            {
                return json_encode($response = array(
                    'status' => 2,
                    'msg' => "Erro ao habilitar veiculo!"
                ));
            }
        }

        if($new == 1)
        {
            $st = DB::update("UPDATE veiculo v
            SET v.h_d = ?,
            v.motivo = ?,
            v.status = ?
            WHERE v.id = ?",
            [
                2,
                $motivo,
                3,
                $id,
            ]);

            if($st)
            {
                return json_encode($response = array(
                    'status' => 1,
                    'msg' => 'Motorista desabilitado com sucesso!'
                ));
            }else
            {
                return json_encode($response = array(
                    'status' => 2,
                    'msg' => "Erro ao desabilitar motorista!"
                ));
            }
        }
    }
}
