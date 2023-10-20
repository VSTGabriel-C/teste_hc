<?php

namespace App\Http\Controllers\Login;
date_default_timezone_set('America/Sao_Paulo');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Session;

class MakeLogin extends Controller
{
    public function autenticate(Request $request)
    {
        $email = $request->user;
        $senha = $request->pass;
        $check = $request->checkbox;
        $req = $request->all();

        $user = (new User)->login_model($request);

        if(empty($email) && empty($senha))
        {
            return redirect()->route('hc_login')->with('msg', 'Impossivel logar no sistema com login e senha fornecidas');
        }

        else if(empty($email))
        {
            return redirect()->route('hc_login')->with('msg', 'Impossivel logar no sistema email não fornecido!');
        }else if(empty($senha))
        {
            return redirect()->route('hc_login')->with('msg', 'Impossivel logar no sistema senha não fornecida!');
        }
        $user = User::where(['email' => $email])->first();
        if(is_null($user) || empty($user)){
            return redirect()->route('hc_login')->with('msg', 'Impossivel logar no sistema email fornecido não foi encontrado!');
        }
	    $decripty = Crypt::decryptString($user->password);
        if($email == $user -> email && $senha == $decripty )
        {
            $admin  = $user->admin;
            $nome   = $user->name;
            $idUser = $user->id;
            $camFoto = $user->camFoto;
            $data_atual = date('Y-m-d');
            $hora_atual = date('H:i:s');
            $request->session()->put('Admin', $admin);
            $request->session()->put('nome', $nome);
            $request->session()->put('idUser', $idUser);
            $request->session()->put('camFoto', $camFoto);
            DB::insert("INSERT INTO login_logout (data_login, hora_login, fk_in_off) VALUES (?, ?, ?)",
            [
                $data_atual,
                $hora_atual,
                $idUser
            ]);
            //Auth::login($user);
            return redirect()->route('hc.novaSolicitacao');
        }

        return redirect()->route('hc_login')->with('msg', 'Impossivel logar no sistema com os dados fornecidos!');
    }

    public function logout(Request $req)
    {
        $resp = $req->session()->all();
        $id = $resp['idUser'];
        $data_atual = date('Y-m-d');
        $hora_atual = date('H:i:s');
        DB::update('UPDATE login_logout set data_logoff = ?,
        hora_logoff = ?
        WHERE fk_in_off = ?',
        [
            $data_atual,
            $hora_atual,
            $id
        ]);
        Auth::logout();
        Session::flush();
        return \redirect()->route('hc_login');
    }

}
