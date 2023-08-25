<?php

namespace App\Http\Controllers\Api\Escala;

use App\Http\Controllers\Controller;
use App\Models\Escala as ModelsEscala;
use App\Models\Escala_motorista as MotoristaEscala;
use App\Models\Escala_motorista_veiculo as VeiculoEscala;
use Illuminate\Http\Request;

class Escala extends Controller
{
    public function newEscalaController(Request $request)
    {
        $escala = new ModelsEscala();

        $res = $escala->newEscala($request->all());

        return $res;
    }

    public function getAllEscalasController(Request $request)
    {
        $escala = (new ModelsEscala())->getAllEscalas();

        return $escala;
    }

    public function getAllEscalasByFilter(Request $request)
    {
        $escalas = (new ModelsEscala())->getAllEscalasByFilter($request->all());

        return $escalas;
    }

    public function getEscalaDataByFilter(Request $request)
    {
        $escala = (new ModelsEscala())->getAllEscalasDataByFilter($request->all());

        return $escala;
    }

    public function activeDeactive(Request $request)
    {
        $escala = (new ModelsEscala())->activeDeactiveEscala($request->all());

        return $escala;
    }

    public function excludeEscala(Request $request)
    {

        $escala = (new ModelsEscala())->excludeEscalasById($request->all());

        return $escala;
    }


    public function editEscala(Request $request)
    {
        $dados = $request->all();

        $algumaVariavelFalse = false;

        if (array_key_exists('dados_basicos', $dados))
        {
            $escala = (new ModelsEscala())->editEscala($dados);
            $algumaVariavelFalse = $algumaVariavelFalse || !$escala;
        }

        if (array_key_exists('horario_mot', $dados))
        {
            $MotEscala = (new MotoristaEscala())->editMotoEscala($dados);
            $algumaVariavelFalse = $algumaVariavelFalse || !$MotEscala;
        }

        if (array_key_exists('new_veic', $dados) || count($dados['observacao_veic_fk']) != 0)
        {
            $VeicEscala = (new VeiculoEscala())->editVeicEscala($dados);
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

    public function verifyExpireEscalas(Request $request)
    {
        $escala = (new ModelsEscala())->verifyExpireEscala();

        return $escala;
    }


    public function retrieveMotoristaByEscalaActiveController(Request $request)
    {
        $escala = (new ModelsEscala())->retrieveMotoristaByEscalaActive();

        return $escala;
    }
    public function retrieveVeiculosByEscalaActiveController(Request $request)
    {
        $escala = (new ModelsEscala())->retrieveVeiculosByEscalaActive();

        return $escala;
    }

}
