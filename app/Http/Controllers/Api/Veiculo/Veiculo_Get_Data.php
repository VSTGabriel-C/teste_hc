<?php

namespace App\Http\Controllers\Api\Veiculo;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Veiculo_Get_Data extends Controller
{
    public function getVeiculos()
    {
        $vehicle = (new Vehicle)->getVehicle();

        return $vehicle;

    }

    public function getVeiculoById(Request $request, $id)
    {
        $vehicle = (new Vehicle)->getVehicle($request, $id);

        return $vehicle;

    }

    public function getVeiculoDisponivel()
    {
        $vehicle = (new Vehicle)->getAvaliableVehicle();

        return $vehicle;

    }

    public function getVeiculoHabilitado()
    {
        $vehicle = (new Vehicle)->getAbleVehicle();

        return $vehicle;

    }
}
