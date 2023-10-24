<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Driver extends Model
{
    protected $fillable = ['name', 'status', 'h_d', 'motive'];

    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }

    public function driverScales()
    {
        return $this->hasMany(DriverScale::class);
    }

    public function newDriver(Request $request)
    {
        $val = Driver::where("name", $request->name)->first();

        if ($val) {
            $msg = [
                'status' => 0,
                'msg' =>  "Já existe um motorista com este nome ($request->name)"
            ];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }

        Driver::create([
            "name" => $request->name,
            "status" => 1,
            "h_d" => 1
        ]);

        $msg = [
            'status' => 1,
            'msg' =>  "Novo motorista cadastrado com sucesso!"
        ];

        return json_encode($msg);
    }

    public function getDriver()
    {
        $var = Driver::select("name", "status", "id", "h_d")->get();
        return json_encode($var);
    }

    public function getAllDrivers()
    {
        $var = Driver::select("name", "status", "id", "h_d")->orderBy("id", "asc");
        $arr = ['data' => $var];
        $sm = $arr;
        return json_encode($sm, JSON_UNESCAPED_UNICODE);
    }
    public function getAvailableDriver()
    {
        $var = Driver::where("status", 1)->get();

        return json_encode($var);
    }
    public function getAbleDriver()
    {
        $var = Driver::where("h_d", 1)->get();

        return json_encode($var);
    }

    public function getDriverById($id)
    {
        $response = Driver::where("id", $id)->first();

        return json_encode($response);
    }

    public function deleteDriver(Request $request)
    {
        $id = $request->id;
        $motivo = $request->mot;

        $re = Driver::where("id", $id)->first();

        $hab_des = $re->h_d;
        $stats = $re->status;


        if ($stats == 2) {
            $response = [
                'status' => 3,
                'msg' => "Não é possivel Habilitar ou Desabilitar um morista enquanto ele estiver atendendo uma solicitação."
            ];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        if ($hab_des == 2) {
            $st = Driver::where("id", $id)->update(["h_d" => 1, "motive" => $motivo, "status" => 1]);

            if ($st) {
                $response = [
                    'status' => 1,
                    'msg' => "Motorista habilitado com sucesso"
                ];
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            } else {
                $response = [
                    'status' => 2,
                    'msg' => "Erro ao habilitar motorista"
                ];
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            }
        }

        if ($hab_des == 1) {
            $st = Driver::where("id", $id)->update(["h_d" => 2, "motive" => $motivo, "status" => 3]);

            if ($st) {
                $response = [
                    'status' => 1,
                    'msg' => "Motorista desabilitado com sucesso"
                ];
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            } else {
                $response = [
                    'status' => 2,
                    'msg' => "Erro ao desabilitar motorista"
                ];
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function editDriver(Request $request)
    {
        $id = $request->id;
        $name = $request->nome;

        $st = Driver::where("id", $id)->update(["name" => $name]);
        if($st)
        {
            $response = [
                'status' => 1,
                'msg' => "Motorista editado com sucesso"
            ];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }else
        {
            $response = [
                'status' => 2,
                'msg' => "Erro ao editar motorista"
            ];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
}
