<?php

namespace App\Http\Controllers\Api\Motorista;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExcludeMotorista extends Controller
{
    public function excludeMotorista(Request $request)
    {
        $id = $request->id;
        $motivo = $request->mot;
        $hab_des;

        $re = DB::select("SELECT m.h_d, m.status FROM motorista m WHERE m.id = ?",
        [
            $id
        ]);

    $query =($re['0']);
    $hab_des = $query->h_d;
    $stats = $query->status;


    if($stats == 2)
    {
    return json_encode($response = [
                'status' => 3,
                'msg' => "Não é possivel Habilitar/Desabilitar um morista enquanto ele estiver atendendo uma solicitação."
            ]);
    }
    if($hab_des == 2)
    {
        $st = DB::update("UPDATE motorista m SET m.h_d = ?, m.motivo = ?, m.status = ? WHERE m.id = ?",
        [
            1,
            $motivo,
            1,
            $id
        ]);

        if($st)
        {
            return json_encode($response = [
                'status' => 1,
                'msg' => "Motorista habilitado com sucesso"
            ]);
        }else
        {
            return json_encode($response = [
                'status' => 2,
                'msg' => "Erro ao habilitar motorista"
            ]);
        }
    }



    if($hab_des == 1)
    {
        $st = DB::update("UPDATE motorista m
        SET m.h_d = ?,
        m.motivo = ?,
        m.status = ?
        WHERE m.id = ?",
        [
            2,
            $motivo,
            3,
            $id,
        ]);

        if($st)
        {
            return json_encode($response = [
                'status' => 1,
                'msg' => "Motorista desabilitado com sucesso"
            ]);
        }else
        {
            return json_encode($response = [
                'status' => 2,
                'msg' => "Erro ao desabilitar motorista"
            ]);
        }
        
    }  
  }
}
