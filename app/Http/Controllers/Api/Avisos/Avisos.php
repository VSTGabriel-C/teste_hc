<?php

namespace App\Http\Controllers\Api\Avisos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Avisos extends Controller
{
    
    public function getAvisos()
    {
        $var = DB::select("SELECT
        DISTINCT
        s.id AS id_sol,
        s.n_ficha AS n_ficha,
        m.nome AS nome_motorista,
        sol.nome AS nome_solicitante,
        u.name AS usuario
        FROM 
        solicitacao s 
            LEFT JOIN 
            motorista m ON s.fk_motorista = m.id
            LEFT JOIN 
            solicitante sol ON s.fk_solicitante = sol.id
            LEFT JOIN 
            users u ON s.fk_usuario = u.id
        WHERE 
        s.ida = 'OK'
        AND s.retorno = 'NOK'
        AND s.cancelamento = 'NOK'
        ORDER BY CAST(s.data AS DATE), CAST(s.data AS TIME)");

        return json_encode($var);
    }

}

?>
