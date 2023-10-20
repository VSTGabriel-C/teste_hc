<?php

namespace App\Http\Controllers\Api\Motorista;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class NewMotorista extends Controller
{
    public function newMotorista(Request $request)
    {
        $driver = (new Driver())->newDriver($request);

        return $driver;
    }

    public function getMotorista()
    {
        $driver = (new Driver())->getDriver();

        return $driver;

    }

  public function getMotoristaL()
    {
        $driver = (new Driver())->getAllDrivers();

        return $driver;

    }
    public function getMotoristaDisponivel()
    {
        $driver = (new Driver())->getAvailableDriver();

        return $driver;

    }
    public function getMotoristaHabilitado()
    {
        $driver = (new Driver())->getAbleDriver();

        return $driver;

    }
}
