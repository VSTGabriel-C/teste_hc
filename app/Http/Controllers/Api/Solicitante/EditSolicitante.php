<?php

namespace App\Http\Controllers\Api\Solicitante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditSolicitante extends Controller
{
    public function editSolicitante(Request $request)
    {
        $id = $request->id;
        $mat = $request->mat;
        $ram = $request->ram;
        $nome = $request->nome;
        $email = $request->email;

        $st = DB::update("UPDATE `solicitante` 
        SET `matricula` = :mat, 
        `ramal` = :ramal, 
        `nome` = :nome, 
        `email` = :email 
        WHERE `solicitante`.`id` = :id",[
            ":id" => $id,
            ":mat" => $mat,
            ":ramal" => $ram,
            ":nome" => $nome,
            ":email" => $email
        ]);
        if($st)
        {
            return json_encode($response = [
                'status' => 1,
                'msg' => "Solicitante editado com sucesso!"
            ]);
        }else
        {
            return json_encode($response = [
                'status' => 2,
                'msg' => "Erro ao editar solicitante!"
            ]);
        }
        return json_encode($response);
    }

    public function editSolicitanteById(Request $request, $id)
    {
        $response = DB::select('select s.matricula, s.ramal, s.nome, s.email from solicitante s where id = :id', 
        [
            ":id" => $id
        ]);

        return json_encode($response);
    }
}
