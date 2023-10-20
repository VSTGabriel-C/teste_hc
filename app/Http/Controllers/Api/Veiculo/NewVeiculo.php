<?php

namespace App\Http\Controllers\Api\Veiculo;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NewVeiculo extends Controller
{
    public function newVeiculo(Request $request)
    {
        $vehicle = (new Vehicle)->newVehicle($request);

        return $vehicle;
    }

}
