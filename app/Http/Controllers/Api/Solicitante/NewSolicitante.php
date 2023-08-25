<?php

namespace App\Http\Controllers\Api\Solicitante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewSolicitante extends Controller
{
    public function newSolicitante(Request $request)
    {
        $n_mat = $request->cod;
        $ramal = $request->ramal;
        $nome = $request->nome;
        $email = $request->email;

        $val = DB::select(' SELECT
                            s.matricula
                            FROM solicitante s
                            WHERE s.matricula = :mat
                            ',
        [
            ":mat" => $n_mat
        ]);

        if (count($val) >= 1)
        {
            $msg = [
                'status' => 0,
                'msg' => "Já existe um solicitante cadastrado com a matricula digitada!",
            ];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }

        DB::insert(" INSERT INTO solicitante (matricula, ramal, nome, email, h_d)
                                    VALUES (:matricula, :ramal, :nome, :email, :h_d)",
            [
                ':matricula' => $n_mat,
                ':ramal' => $ramal,
                ':nome' => $nome,
                ':email' => $email,
                ':h_d' => 1
            ]);

        $msg = [
            'status' => 1,
            'msg' => "Novo Solicitante cadastrado com sucesso!",
        ];

        return json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    public function newSolicitante_bot(Request $request)
    {
        $ramal = $request->ramal;
        $nome = $request->nome;
        $email = $request->email;

        $val = DB::select("SELECT
        s.nome
        FROM solicitante s
        WHERE s.nome = :nome
                        ",
        [
            ":nome" => $nome
        ]);

        if (count($val) >= 1)
        {
            $msg = [
                'status' => 0,
                'msg' => "Já existe um solicitante cadastrado com esse nome.",
            ];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }

        DB::insert(" INSERT INTO solicitante (ramal, nome, email, h_d)
                                    VALUES (:ramal, :nome, :email, :h_d)",
            [
                ':ramal' => $ramal,
                ':nome' => $nome,
                ':email' => $email,
                ':h_d' => 1
            ]);

        $msg = [
            'status' => 1,
            'msg' => "Novo Solicitante cadastrado com sucesso!",
        ];

        return json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    public function getSolicitante(Request $request)
    {
        $req =$request->all();
        $arr = [];


        $res = DB::select('select * from solicitante order by id asc');

        $arr[] = ['data' => $res];
        $sm = $arr;
       return json_encode($sm, JSON_UNESCAPED_UNICODE);
    }

    public function getSolicitanteS(Request $request)
    {
        $res = DB::select('select * from solicitante');


       return json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function getSolicitante_condition(Request $request)
    {
        $res = DB::table('solicitante')->orderBy('nome')->get();

        foreach ($res as $key)
        {

            if($key->h_d == 1)
            {
                $lista[] = [$key];
            }else
            {
                $lista[] = [];
            }

        }

        return json_encode($lista);

    }
}
