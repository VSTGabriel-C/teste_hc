<?php

namespace App\Http\Controllers\Api\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesabilitarUser extends Controller
{
    public function hbl_desb(Request $request)
    {
        $ativo = $request->ativo;
        $id = $request->id;

        $msg = array();

        if($ativo == 1)
        {
            $hbl_des = DB::update("UPDATE users 
            SET ativo = ?
            WHERE id = ?",
            [
                0,
                $id
            ]);

            if($hbl_des)
            {
                $msg = array(
                    "status" => 1,
                    "msg" => "Usuario desabilitado com sucesso!"
                );
                return json_encode($msg, JSON_UNESCAPED_UNICODE);

            }else
            {
                $msg = array(
                    "status" => 0,
                    "msg" => "Erro ao desabilitar usuario!"
                );
                return json_encode($msg, JSON_UNESCAPED_UNICODE);

            }


        }else if($ativo == 0)
        {
            $hbl_des = DB::update("UPDATE users 
            SET ativo = ?
            WHERE id = ?",
            [
                1,
                $id
            ]);

            if($hbl_des)
            {
                $msg = array(
                    "status" => 1,
                    "msg" => "Usuario habilitado com sucesso!"
                );
                return json_encode($msg, JSON_UNESCAPED_UNICODE);

            }else
            {
                $msg = array(
                    "status" => 0,
                    "msg" => "Erro ao habilitar usuario!"
                );
                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            }
        }

    }
}
