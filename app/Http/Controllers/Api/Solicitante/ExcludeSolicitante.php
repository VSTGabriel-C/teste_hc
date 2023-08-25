<?php

namespace App\Http\Controllers\Api\Solicitante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExcludeSolicitante extends Controller
{
    public function excludeSolicitante(Request $request)
    {
        $id = $request->id;
        $motivo = $request->motivo;
        $new;

        $re = DB::select("SELECT sol.h_d FROM solicitante sol
        WHERE sol.id = ?", 
        [
            $id
        ]);

        foreach ($re as $key)
        {
            $new = $key->h_d;
        }


        if($new == 2)
        {
            $st = DB::update("UPDATE solicitante s
            SET s.h_d = ?,
            s.motivo = ? 
            WHERE s.id = ?",
            [   
                1,
                $motivo,
                $id
            ]);

            if($st)
            {
                return json_encode($response = [
                    'status' => 1,
                    'msg' => "Solicitante habilitado com sucesso!"
                ]);
            }else
            {
                return json_encode($response = [
                    'status' => 2,
                    'msg' => "Erro ao habilitar solicitante!"
                ]);
            }
        }

        if($new == 1)
        {
            $st = DB::update("UPDATE solicitante sol
            SET sol.h_d = ?,
            sol.motivo = ?
            WHERE sol.id = ?", 
            [
                2,
                $motivo,
                $id
            ]);

            if($st)
            {
                return json_encode($response = [
                    'status' => 1,
                    'msg' => "Solicitante desabilitado com sucesso!"
                ]);
            }else
            {
                return json_encode($response = [
                    'status' => 2,
                    'msg' => "Erro ao desabilitar solicitante!"
                ]);
            }
        }
    }
}
