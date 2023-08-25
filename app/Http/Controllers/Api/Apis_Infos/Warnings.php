<?php

namespace App\Http\Controllers\Api\Apis_Infos;
date_default_timezone_set('America/Sao_Paulo');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sql;

class Warnings extends Controller
{
    public function makeMsg(Request $request)
    {
        $sql = new Sql();

        $newArr = array();

        $data_atual = date("Y-m-d");


        $response = $sql->select("SELECT
        *
        FROM
        solicitacao s
        WHERE
        s.ida = 'OK'
        AND s.retorno = 'NOK'
        AND s.cancelamento = 'NOK'
        AND CAST(s.data AS DATE) < '{$data_atual}'");

        if(count($response) > 0)
        {
            $newArr[] = [
                "status"    => "ok",
                "msg"       => "Ainda existe solicitações em aberto.",
                "qtde"      => count($response)
            ];
        }else {
            $newArr[] = [
                "status"    => "Error",
                "msg"       => "Não existe solicitação em aberto.",
                "qtde"      => 0
            ];
        }

        return json_encode($newArr, JSON_UNESCAPED_UNICODE);
    }
}
