<?php

namespace App\Models;

use Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginLogout extends Model
{
    protected $fillable = ['date_login', 'hour_login', 'date_logoff', "fk_in_off"];

    public function logout(Request $req){
        $resp = $req->session()->all();
        $id = $resp['idUser'];
        $data_atual = date('Y-m-d');
        $hora_atual = date('H:i:s');

        LoginLogout::where("fk_in_off", $id)->update(["data_logoff" =>$data_atual, "hour_logoff" => $hora_atual]);
        Auth::logout();
        Session::flush();
        return \redirect()->route('hc_login');
    }
}
