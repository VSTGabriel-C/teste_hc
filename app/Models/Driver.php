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
        $arr= ['data' => $var];
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
}
