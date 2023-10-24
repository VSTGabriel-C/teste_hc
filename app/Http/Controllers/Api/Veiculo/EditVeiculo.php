<?php

namespace App\Http\Controllers\Api\Veiculo;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EditVeiculo extends Controller
{
    public function editVeiculo(Request $request)
    {
        $vehicle = (new Vehicle)-> editVehicle($request);

        return $vehicle;

    }

}
