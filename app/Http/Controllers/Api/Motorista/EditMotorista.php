<?php

namespace App\Http\Controllers\Api\Motorista;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditMotorista extends Controller
{

    public function editMotorista(Request $request)
    {
        $driver = (new Driver)->editDriver($request);

        return $driver;
    }
}
