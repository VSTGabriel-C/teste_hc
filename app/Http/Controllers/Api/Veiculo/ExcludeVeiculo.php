<?php

namespace App\Http\Controllers\Api\Veiculo;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ExcludeVeiculo extends Controller
{
    public function excludeVeiculo(Request $request)
    {
        $vehicle = (new Vehicle)->deleteVehicle($request);

        return $vehicle;
    }
}
