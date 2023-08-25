<?php

namespace App\Http\Controllers\Api\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class NewUser extends Controller
{
    public function newUser(Request $request)
    {

        $email = $request->u_email;
        $nome = $request->u_nome;
        $senha = $request->u_senha;
        $confirm = $request->s_confirm;
        $tipo = $request->tipo_user;
        $newTipo = 0;
        $data_atual = date("Y-m-d");
        $newPic = $this->storeIm($request);

        $msg = array();

        $if = DB::select("SELECT
        u.email
        FROM users u
        WHERE u.email = ?",
        [
            $email
        ]);

        if($if)
        {
            $msg = array(
                'status' => 1,
                'msg' => "E-mail informado já está cadastrado"
            );
            return redirect()->route('hc_add_new_admin', $msg);
        }
        else
        {
            if($senha == $confirm)
            {
                if($tipo == "Admin")
                {
                    $newTipo = 1;
                }
                else if($tipo == "Normal")
                {
                    $newTipo = 2;
                }

                DB::insert("INSERT INTO users (email, password, data, name, admin, ativo, camFoto)
                VALUES (?, ?, ?, ?, ?, ?, ?)",[
                    $email,
                    Crypt::encryptString($senha),
                    $data_atual,
                    $nome,
                    $newTipo,
                    1,
                    $newPic
                ]);
                $msg = array(
                    'status' => 0,
                    'msg' => "Usuário cadastrado com sucesso!"
                );

                
                return redirect()->route('hc_add_new_admin', $msg);
                
            }
            else
            {
                $msg = array(
                    'status' => 1,
                    'msg' => "Senhas não conferem!"
                );
                return redirect()->route('hc_add_new_admin', $msg);
            }
        }
    }

    public function storeIm ($request)
    {
        $nameFile = '';

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $name = uniqid(date('dmY'));

            $extension = $request->all()['image']->extension();

            $path="public/images/fotos";
            
            if($extension != 'jpeg' && $extension != 'png' && $extension != 'svg' && $extension != "jpg")
            {
             return redirect()
             ->back()
             ->with('error', 'Falha ao fazer upload, formato do arquivo está errado.')
             ->withInput();
            }
            $nameFile = "{$name}.{$extension}";

            $upload = $request->file('image')->storeAS($path, $nameFile);
            if ( !$upload )
                return redirect()
                            ->back()
                            ->with('error', 'Falha ao fazer upload')
                            ->withInput();
        }
        return $nameFile;
    }
}
