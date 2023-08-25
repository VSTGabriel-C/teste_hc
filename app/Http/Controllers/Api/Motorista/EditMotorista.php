<?php

namespace App\Http\Controllers\Api\Motorista;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditMotorista extends Controller
{

    public function editMotorista(Request $request)
    {
        $id = $request->id;
        $nome = $request->nome;
        $st = DB::update("UPDATE motorista
                         SET nome = :nome 
                         WHERE id = :id", [
                             ':id' => $id, 
                             ":nome" => $nome
                            ]);
        if($st)
        {
            return json_encode($response = [
                'status' => 1,
                'msg' => "Motorista editado com sucesso"
            ]);
        }else
        {
            return json_encode($response = [
                'status' => 2,
                'msg' => "Erro ao editar motorista"
            ]);
        }
        return json_encode($response);
    }

    public function getMotoristaById(Request $request, $id)
    {
        $response = DB::select('select m.nome from motorista as m where id = :id', 
        [
            ":id" => $id
        ]);

        return json_encode($response);
    }
}
