<?php

namespace App\Http\Controllers\Api\Motorista;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExcludeMotorista extends Controller
{
    public function excludeMotorista(Request $request)
    {
        $driver = (new Driver)->deleteDriver($request);

        return $driver;
    }
}
