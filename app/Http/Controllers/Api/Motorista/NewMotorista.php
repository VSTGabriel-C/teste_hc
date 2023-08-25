<?php

namespace App\Http\Controllers\Api\Motorista;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewMotorista extends Controller
{
    public function newMotorista(Request $request)
    {
        $nome = $request->nome;

        $val = DB::select('select nome from motorista where nome = :nome', [":nome" => $nome]);

        if(count($val) >= 1)
        {
            $msg = [
                'status' => 0,
                'msg' =>  "Já existe um motorista com este nome ($nome)"
            ];
            return json_encode($msg);
        }

        DB::insert('insert into motorista (nome, status, h_d) values (:nome, :status, :h_d)',
        [
            ":nome" => $nome,
            ':status' => 1,
            ":h_d" => 1
        ]);
        $msg = [
            'status' => 1,
            'msg' =>  "Novo motorista cadastrado com sucesso!"
        ];

        return json_encode($msg);

    }

    public function getMotorista(Request $request)
    {
        $var = DB::select('select m.nome, m.status, m.id, m.h_d from motorista as m');
        return json_encode($var);
    }

  public function getMotoristaL(Request $request)
      {
          $req =$request->all();
          $arr = [];
          $var = DB::select('select m.nome, m.status, m.id, m.h_d from motorista as m order by id asc');
            $arr[] = ['data' => $var];
            $sm = $arr;
            return json_encode($sm, JSON_UNESCAPED_UNICODE);
     }
    public function getMotoristaDisponivel()
    {
        $var = DB::select("SELECT
        *
        FROM motorista m
        WHERE m.status = 1");

        return json_encode($var);
    }
    public function getMotoristaHabilitado()
    {
        $var = DB::select("SELECT
        *
        FROM motorista m
        WHERE m.h_d = 1");

        return json_encode($var);
    }
}
