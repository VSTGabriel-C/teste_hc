<?php

namespace App\Http\Controllers\Api\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class EditarUser extends Controller
{
  public function allUserss()
    {

        $res = DB::select("SELECT
        * 
        FROM users u");
        return json_encode($res);
    }

    public function allUserssL(Request $request)
    {
        $req = $request->all();
        $arr = [];
     
        $res = DB::select('select * from users u order by id asc');
        $arr[] = ['data' => $res];
        $sm = $arr;
        return json_encode($sm, JSON_UNESCAPED_UNICODE);
    }

    public function get_Users_By_Id($id)
    {
        $res = DB::select("SELECT
        u.name,
        u.email
        FROM users u
        WHERE u.id = ?", 
        [
            $id
        ]);

        return json_encode($res);
    }


    public function edit_User_By_Id(Request $request)
    {
        $name = $request->nome;
        $e_mail = $request->email;
        $senha = $request->password;
        $senha_C = $request->password_C;
        $ids = $request ->idE;
        $picEdit = $this->storeImE($request, $ids);



        if($picEdit != '')
        {
            $result = DB::update("UPDATE users
            SET `camFoto` = ?
            WHERE id = ?",
            [
                $picEdit,
                $ids
            ]);
        
        if($result)
        {
            $msg = array(
                "status" => 1,
                "msg" => "Foto Editada com sucesso. Por favor relogue no sistema!"
            );

            return redirect()->route('hc_edit_new_admin', $msg); 
        }else
        {
            $msg = array(
                "status" => 0,
                "msg" => "Não foi possivel editar a foto."
            );

            return redirect()->route('hc_edit_new_admin', $msg);
        } 
    }

        if(is_null($senha) && is_null($senha_C))
        {
            $result = DB::update("UPDATE users
            SET `name` = ?,
            `email` = ?
            WHERE id= ?",
            [
                $name,
                $e_mail,
                $ids
            ]);

            if($result)
            {
                $msg = array(
                    "status" => 1,
                    "msg" => "Usuario editado com sucesso!"
                );

                return redirect()->route('hc_edit_new_admin', $msg); 
            }else
            {
                $msg = array(
                    "status" => 0,
                    "msg" => "Não foi possivel editar o usuario pois nada foi alterado."
                );

                return redirect()->route('hc_edit_new_admin', $msg); 
            }    
        }

            if($senha == $senha_C)
            {
                $result = DB::update("UPDATE users
                SET `name` = ?,
                `email` = ?,
                `password` = ?
                WHERE id = ?",
                [
                    $name,
                    $e_mail,
                    Crypt::encryptString($senha),
                    $ids
                ]);
                if($result)
                {
                    $msg = array(
                        "status" => 1,
                        "msg" => "Usuario editado com sucesso!"
                    );

                    return redirect()->route('hc_edit_new_admin', $msg); 
                }else
                {
                    $msg = array(
                        "status" => 0,
                        "msg" => "Não foi possivel editar o usuario (Senhas não conferem) !"
                    );

                    return redirect()->route('hc_edit_new_admin', $msg); 
                }    
            }else
            {
                $msg = array(
                    "status" => 0,
                    "msg" => "Não foi possivel alterar o usuario (Senhas não conferem) !"
                );
                return redirect()->route('hc_edit_new_admin', $msg); 
            }
    }
    public function storeImE ($request, $id)
    {

        $res = DB::select("SELECT
        u.camFoto
        FROM users u
        WHERE u.id = ?", 
        [
            $id
        ]);

        $nameFile = '';

        if ($request->hasFile('imageE') && $request->file('imageE')->isValid()) {
            if($res[0]->camFoto != '')
            {
                unlink(public_path('/storage/images/fotos/'.$res[0]->camFoto));
            }

            $name = uniqid(date('dmY'));

            $extension = $request->all()['imageE']->extension();

            $path="public/images/fotos";
            
            if($extension != 'jpeg' && $extension != 'png' && $extension != 'svg' && $extension != "jpg")
            {
             return redirect()
             ->back()
             ->with('error', 'Falha ao fazer upload, formato do arquivo está errado.')
             ->withInput();
            }
            $nameFile = "{$name}.{$extension}";

            $upload = $request->file('imageE')->storeAS($path, $nameFile);
            if ( !$upload )
                return redirect()
                            ->back()
                            ->with('error', 'Falha ao fazer upload')
                            ->withInput();
        }

        return $nameFile;
    }
}
