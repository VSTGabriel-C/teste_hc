<?php

namespace App\Http\Controllers\Api\Veiculo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Veiculo_Get_Data extends Controller
{
    public function getVeiculos(Request $request)
    {
        $req =$request->all();
        $arr = [];
        

        $response = DB::select('SELECT v.id, v.pref, v.placa, v.tipo, v.marca, v.status, v.h_d, v.motivo FROM veiculo AS v order by id asc');
        $arr[] = ['data' => $response];
        $sm = $arr;
       return json_encode($sm, JSON_UNESCAPED_UNICODE);
    }
}
