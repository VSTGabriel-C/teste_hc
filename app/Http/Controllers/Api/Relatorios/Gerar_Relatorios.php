<?php

namespace App\Http\Controllers\Api\Relatorios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Relatorio;

class Gerar_Relatorios extends Controller
{
    public function gerar_Relatorio(Request $request)
    {

        //$var = $this->rel_Preview($request->all());
        $r = new Relatorio($request->all());
        $var = $r->gerar_Xls();

        return $var;
    }

    public function rel_Preview($valores)
    {
        // if(Auth::check() === true)
        // {
        //     Auth::user();
        //     return view('Dashboard_Principal.Relatorios.Preview_Relatorio');
        // }else
        // {
        //     return view('Login.Login_HC');
        // }
    }
}
