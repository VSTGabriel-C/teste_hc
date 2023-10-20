<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    protected $fillable = ['type', 'pref', 'plate', 'brand', 'status', 'h_d', 'motive', 'email'];

    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }

    public function vehicleScales()
    {
        return $this->hasMany(VehicleScale::class);
    }

    public function newVehicle(Request $request)
    {
        $pref = $request->pref;
        $placa = $request->placa;
        $tipo = $request->tipo;
        $marca = $request->marca;

        $check = Vehicle::where("pref", $pref)->first();

        if($check)
        {
            $apiResponse = [
                "status" => 0,
                "msg"    => "Já exite um veiculo com o codigo digitado!"
            ];

            return json_encode($apiResponse, JSON_UNESCAPED_UNICODE);
        }

        $response = Vehicle::create([
            "type" => $tipo,
            "pref" => $pref,
            "plate" => $placa,
            "brand" => $marca,
            "status" =>1,
            "h_d" =>1,
        ]);

        if($response)
        {
            $apiResponse = [
                "status" => 1,
                "msg"    => "Veiculo cadastrado com sucesso!"
            ];

            return json_encode($apiResponse);
        }else
        {
            $apiResponse = [
                "status" => 0,
                "msg"    => "Erro ao inserir novo veiculo!"
            ];

            return json_encode($apiResponse);
        }

    }

    public function getVehicle()
    {

        $response = Vehicle::select("id", "pref", "plate", "brand", "status", "h_d", "motive")->orderBy("id", "asc")->get();
        $arr = ['data' => $response];
        $sm = $arr;
       return json_encode($sm, JSON_UNESCAPED_UNICODE);
    }

    public function getVehicleById(Request $request, $id)
    {
        $response = Vehicle::where("id", $id)->select("id", "pref", "plate", "brand")->get();
        return json_encode($response);
    }

    public function getAvaliableVehicle()
    {
        $var = Vehicle::where("status", 1)->get();
        return json_encode($var);
    }
    public function getAbleVehicle()
    {
        $var = Vehicle::where("h_d", 1)->get();

        return json_encode($var);
    }
}
