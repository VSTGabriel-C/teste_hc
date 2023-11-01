<?php

namespace App\Http\Controllers\Api\Escala;

use App\Http\Controllers\Controller;
use App\Models\DriverScale;
use App\Models\Scale;
use App\Models\VehicleScale;
use Illuminate\Http\Request;

class Escala extends Controller
{
    public function newEscalaController(Request $request)
    {
        $escala = new Scale;

        $res = $escala->newEscala($request->all());

        return $res;
    }

    public function getAllEscalasController()
    {
        $escala = (new Scale)->getAllEscalas();

        return $escala;
    }

    public function getAllEscalasByFilter(Request $request)
    {
        $escalas = (new Scale)->getAllEscalasByFilter($request->all());

        return $escalas;
    }

    public function getEscalaDataByFilter(Request $request)
    {
        $escala = (new Scale)->getAllEscalasDataByFilter($request->all());

        return $escala;
    }

    public function activeDeactive(Request $request)
    {
        $escala = (new Scale)->activeDeactiveEscala($request->all());

        return $escala;
    }

    public function excludeEscala(Request $request)
    {

        $escala = (new Scale)->excludeEscalasById($request->all());

        return $escala;
    }


    public function editEscala(Request $request)
    {
        $dados = $request->all();

        $algumaVariavelFalse = false;

        if (array_key_exists('dados_basicos', $dados))
        {
            $escala = (new Scale)->editEscala($dados);
            $algumaVariavelFalse = $algumaVariavelFalse || !$escala;
        }

        if (array_key_exists('horario_mot', $dados))
        {
            $MotEscala = (new DriverScale)->EditDriverScale($dados);
            $algumaVariavelFalse = $algumaVariavelFalse || !$MotEscala;
        }

        if (array_key_exists('new_veic', $dados) || count($dados['observacao_veic_fk']) != 0)
        {
            $VeicEscala = (new VehicleScale)->editVeicEscala($dados);
            $algumaVariavelFalse = $algumaVariavelFalse || !$VeicEscala;
        }

        if ($algumaVariavelFalse)
        {
            return false;
        } else
        {
            return true;
        }
    }

    public function verifyExpireEscalas()
    {
        $escala = (new Scale)->verifyExpireEscala();

        return $escala;
    }


    public function retrieveMotoristaByEscalaActiveController()
    {
        $escala = (new Scale)->retrieveMotoristaByEscalaActive();

        return $escala;
    }
    public function retrieveVeiculosByEscalaActiveController()
    {
        $escala = (new Scale)->retrieveVeiculosByEscalaActive();

        return $escala;
    }

}
