<?php

namespace App\Http\Controllers\Api\V_Solicitacoes;
header("Content-type: text/html; charset=utf8");
use App\Http\Controllers\Controller;
use App\Models\Solicitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Sql;
class Visualizar_Solicitacoes extends Controller
{
    public function getAllSolicitations()
    {
        $solicitation = (new Solicitation)->getAllSolicitations();

        return $solicitation;
    }

    public function searchSolicitations(Request $request)
    {
        $req =$request->all();
        $arr = [];
        $arrS = [];
        $arrS[] = ['n_ficha' => $req["n_ficha"] , 'data' => $req["data"], 'nome' => $req["nome"]];
        $sm = $arrS;
        $add = $this->addQuery($sm['0']);

        $query  = $this->queryF($add);

        $sql = new SQL();

        $exec = $sql->select($query);

        if(count($exec) > 0)
        {
            $newValues = $exec;
            // $newValues = $this->to_utf8($exec);
            //return json_encode($newValues, JSON_UNESCAPED_UNICODE);

            $arr[] = ['data' => $newValues];
            $smS = $arr;

		return json_encode($smS, JSON_UNESCAPED_UNICODE);
        }else
        {
            return json_encode($msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar a solicitação com os dados fornecidos!"
            ), JSON_UNESCAPED_UNICODE);
        }
    }

    public function searchSolicitationsDia(Request $request)
    {
        $req =$request->all();
        $arr = [];
        $arrS = [];
        $arrS[] = ['n_ficha' => $req["n_ficha"] , 'data' => $req["data"], 'nome' => $req["nome"]];
        $sm = $arrS;
        $add = $this->addQuery($sm['0']);
        $query  = $this->queryFDIA($add);

        $sql = new SQL();

        $exec = $sql->select($query);

        if(count($exec) > 0)
        {

            //$newValues = $this->to_utf8($exec);
            $newValues = $exec;
            $newValues = $exec;
            // $newValues = $this->to_utf8($exec);

            //return json_encode($newValues, JSON_UNESCAPED_UNICODE);

            $arr[] = ['data' => $newValues];
            $smS = $arr;

		return json_encode($smS, JSON_UNESCAPED_UNICODE);
        }else
        {
            return json_encode($msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar solicitações na data de hoje!"
            ), JSON_UNESCAPED_UNICODE);
        }
    }

    public function searchSolicitationById(Request $request, $id)
    {
         $query = $this->queryById($id);

         $sql = new Sql();

         $exec = $sql->select($query);

         $decript = $exec;


         foreach ($exec as $key => $value) {
             $decript[$key]['nome_paciente'] = Crypt::decryptString($exec[$key]['nome_paciente']);
         }

         return json_encode($decript,JSON_UNESCAPED_UNICODE);

        //  return json_encode($this->to_utf8($decript),JSON_UNESCAPED_UNICODE);
     }

    private function addQuery($request)
    {
        $req = $request;
        $filtro = array_filter($req);
        $query = "";

        if(count($filtro) == 1)
        {
            foreach($filtro as $key => $value)
            {
                if(\DateTime::createFromFormat('Y-m-d', $value) !== FALSE)
                {
                    $query = "WHERE CAST(s.`$key` AS DATE) = '$value'";
                }
                else if($key == "nome")
                {
                    $query .= "WHERE m.$key = '$value'";
                }
                else
                {
                    $query .= "WHERE s.$key = '$value'";
                }
            }
            return $query;
        }

        foreach($filtro as $key => $value)
        {
            if(\strpos($query, 'WHERE') === false)
            {
                if(\DateTime::createFromFormat('Y-m-d', $value) !== FALSE)
                {
                    $query .= "WHERE CAST(s.`$key` AS DATE) = '$value'";
                }
                else if($key == "nome")
                {
                    $query .= "WHERE m.$key = '$value'";
                }
                else
                {
                    $query .= " WHERE s.$key = '$value'";
                }
            }
            else if(\strpos($query, 'WHERE') !== false)
            {
                if(\DateTime::createFromFormat('Y-m-d', $value) !== FALSE)
                {
                    $query .= "AND CAST(s.`$key` AS DATE) = '$value'";
                }
                else if($key == "nome")
                {
                    $query .= "AND m.$key = '$value'";
                }
                else
                {
                    $query .= " AND s.$key = '$value'";
                }
            }
        }

        return $query;
    }


    public function to_utf8($in)
    {
        // dd($in);
        // exit;
        $newArr = array();
	$new = array();
	foreach($in as $key => $value)
	{
	    $new[] = $value;
	    foreach($new as $key2 => $value2)
	    {
            $newArr[$key2] = [
            'id_solicitacao' => utf8_encode($value2['id_solicitacao']),
            'numero_ficha' => utf8_encode($value2['numero_ficha']),
            'solicitante' => utf8_encode($value2['solicitante']),
            'nome_paciente' => $value2['nome_paciente'],
            'atendida_por' => utf8_encode($value2['atendida_por']),
            'contato_plantao' => utf8_encode($value2['contato_plantao']),
            'sol_ramal' => utf8_encode($value2['sol_ramal']),
            'End_Loc_ident' => utf8_encode($value2['End_Loc_ident']),
            'hc' => utf8_encode($value2['hc']),
            'incor' => utf8_encode($value2['incor']),
            'ida' => utf8_encode($value2['ida']),
            'retorno' => utf8_encode($value2['retorno']),
            'cancelamento' => utf8_encode($value2['cancelamento']),
            'portaria' => utf8_encode($value2['portaria']),
            'radio' => utf8_encode($value2['radio']),
            'motorista_nome' => utf8_encode($value2['motorista_nome']),
            'veiculo_pref' => utf8_encode($value2['veiculo_pref']),
            'status_viagem' => utf8_encode($value2['status_viagem']),
            'oxigenio' => utf8_encode($value2['oxigenio']),
            'obeso' => utf8_encode($value2['obeso']),
            'isolete' => utf8_encode($value2['isolete']),
            'maca' => utf8_encode($value2['maca']),
            'isolamento' => utf8_encode($value2['isolamento']),
            'isolamento_motivo' => utf8_encode($value2['isolamento_motivo']),
            'obito' => utf8_encode($value2['obito']),
            'uti' => utf8_encode($value2['uti']),
            'destino' => utf8_encode($value2['destino']),
            'data_solicitacao' => utf8_encode($value2['data_solicitacao']),
            'hora_solicitacao' => utf8_encode($value2['hora_solicitacao']),
            'ch_horario' => utf8_encode($value2['ch_horario']),
            'ch_kilometro' => utf8_encode($value2['ch_kilometro']),
            'vt_horario' => utf8_encode($value2['vt_horario']),
            'vt_kilometro'=> utf8_encode($value2['vt_kilometro']),
            'horario_saida' =>  utf8_encode($value2['horario_saida']),
            'sol_km' => utf8_encode($value2['sol_km']),
            'n_ramalN' => utf8_encode($value2['n_ramalN'])
		];
	    }
	}

	return $newArr;
    }


    public function queryById($id)
    {
        $result = Solicitation::select([
            's.id as id_solicitacao',
            's.n_ficha as numero_ficha',
            's.end_loc_ident as End_Loc_ident',
            'sol.nome as solicitante',
            'sol.ramal as sol_ramal',
            'p.nome_paciente',
            's.atendida_por',
            's.contato_plantao',
            's.hc',
            's.incor',
            's.ida',
            's.retorno',
            's.cancelamento',
            's.portaria',
            's.radio',
            'm.nome as motorista_nome',
            'v.pref as veiculo_pref',
            'v.status as status_viagem',
            'ut.oxigenio',
            'ut.obeso',
            'ut.isolete',
            'ut.maca',
            'ut.isolamento',
            'ut.d_isolamento as isolamento_motivo',
            'ut.obito',
            'ut.uti',
            's.destino',
            's.data as data_solicitacao',
            's.hora as hora_solicitacao',
            DB::raw('IFNULL(ch.horario, 0) as ch_horario'),
            DB::raw('IFNULL(ch.km, 0) as ch_kilometro'),
            DB::raw('IFNULL(vt.horario, 0) as vt_horario'),
            DB::raw('IFNULL(vt.km, 0) as vt_kilometro'),
            DB::raw('IFNULL(di.horario, 0) as horario_saida'),
            DB::raw('IFNULL(di.km, 0) as sol_km'),
            DB::raw('IFNULL(rm.n_ramal,0) as n_ramalN')
        ])
        ->from('solicitacao as s')
        ->leftJoin('motorista as m', 's.fk_motorista', '=', 'm.id')
        ->leftJoin('paciente as p', 's.fk_paciente', '=', 'p.id')
        ->leftJoin('solicitante as sol', 's.fk_solicitante', '=', 'sol.id')
        ->leftJoin('veiculo as v', 's.fk_veiculo', '=', 'v.id')
        ->leftJoin('utencil as ut', 's.fk_utencilios', '=', 'ut.id')
        ->leftJoin('dir_ch as ch', 's.id', '=', 'ch.fk_solicitation_ch')
        ->leftJoin('dir_volta as vt', 's.id', '=', 'vt.fk_solicitation')
        ->leftJoin('distancia_perc as dp', 'dp.id', '=', 's.fk_dist_perc')
        ->leftJoin('dir_ida as di', 'di.id', '=', 'dp.fk_saida')
        ->leftJoin('ramais as rm', 's.fk_id_ramais', '=', 'rm.id')
        ->where('s.id', $id)
        ->groupBy('s.id')
        ->get();

        return $result;
    }


    public function queryFDIA($where)
    {

        $rawQuery = "SELECT DISTINCT
        s.id AS id_solicitacao,
        s.n_ficha AS numero_ficha,
        s.end_loc_ident AS End_Loc_ident,
        sol.nome AS solicitante,
        sol.ramal AS sol_ramal,
        p.nome_paciente,
        s.atendida_por,
        s.contato_plantao,
        s.hc,
        s.incor,
        s.ida,
        IFNULL(s.retorno,'NOK') AS retorno,
        IFNULL(s.cancelamento,'NOK') AS cancelamento,
        s.portaria,
        s.radio,
        m.nome AS motorista_nome,
        v.pref AS veiculo_pref,
        v.`status` AS status_viagem,
        ut.oxigenio,
        ut.obeso,
        ut.isolete,
        ut.maca,
        ut.isolamento,
        ut.d_isolamento AS isolamento_motivo,
        ut.obito,
        ut.uti,
        s.destino,
        DATE_FORMAT(CAST(s.data AS DATE),'%d-%m-%Y') AS data_solicitacao,
        s.hora AS hora_solicitacao,
        IFNULL(ch.horario, 0) AS ch_horario,
        IFNULL(ch.km, 0) AS ch_kilometro,
        IFNULL(vt.horario, 0) AS vt_horario,
        IFNULL(vt.km, 0) AS vt_kilometro,
        di.horario as horario_saida,
        IFNULL(di.km, 0) AS sol_km,
        IFNULL(rm.n_ramal,0) as n_ramalN
    FROM
        solicitacao s
            LEFT JOIN
        motorista m ON s.fk_motorista = m.id
            LEFT JOIN
        paciente p ON s.fk_paciente = p.id
            LEFT JOIN
        solicitante sol ON s.fk_solicitante = sol.id
            LEFT JOIN
        veiculo v ON s.fk_veiculo = v.id
            LEFT JOIN
        utencil ut ON s.fk_utencilios = ut.id
            LEFT JOIN
        dir_ch ch ON s.id = ch.fk_solicitation_ch
            LEFT JOIN
        dir_volta vt ON s.id = vt.fk_solicitation
            LEFT JOIN
        distancia_perc dp ON dp.id = s.fk_dist_perc
            LEFT JOIN
        dir_ida di ON di.id = dp.fk_saida
            LEFT JOIN
        ramais rm ON s.fk_id_ramais = rm.id
        $where
    GROUP BY s.id , data_solicitacao
    ORDER BY s.id";

        return $rawQuery;
    }


    public function queryF($where)
    {
        $rawQuery = "SELECT DISTINCT
        s.id AS id_solicitacao,
        s.n_ficha AS numero_ficha,
        s.end_loc_ident AS End_Loc_ident,
        sol.nome AS solicitante,
        sol.ramal AS sol_ramal,
        p.nome_paciente,
        s.atendida_por,
        s.contato_plantao,
        s.hc,
        s.incor,
        s.ida,
        s.retorno,
        s.cancelamento,
        s.portaria,
        s.radio,
        m.nome AS motorista_nome,
        v.pref AS veiculo_pref,
        v.`status` AS status_viagem,
        ut.oxigenio,
        ut.obeso,
        ut.isolete,
        ut.maca,
        ut.isolamento,
        ut.d_isolamento AS isolamento_motivo,
        ut.obito,
        ut.uti,
        s.destino,
        DATE_FORMAT(CAST(s.data AS DATE),'%d-%m-%Y') AS data_solicitacao,
        s.hora AS hora_solicitacao,
        IFNULL(ch.horario, 0) AS ch_horario,
        IFNULL(ch.km, 0) AS ch_kilometro,
        IFNULL(vt.horario, 0) AS vt_horario,
        IFNULL(vt.km, 0) AS vt_kilometro,
        IFNULL(di.horario, 0) AS horario_saida,
        IFNULL(di.km, 0) AS sol_km,
        IFNULL(rm.n_ramal,0) as n_ramalN
    FROM
        solicitacao s
            LEFT JOIN
        motorista m ON s.fk_motorista = m.id
            LEFT JOIN
        paciente p ON s.fk_paciente = p.id
            LEFT JOIN
        solicitante sol ON s.fk_solicitante = sol.id
            LEFT JOIN
        veiculo v ON s.fk_veiculo = v.id
            LEFT JOIN
        utencil ut ON s.fk_utencilios = ut.id
            LEFT JOIN
        dir_ch ch ON s.id = ch.fk_solicitation_ch
            LEFT JOIN
        dir_volta vt ON s.id = vt.fk_solicitation
            LEFT JOIN
        distancia_perc dp ON dp.id = s.fk_dist_perc
            LEFT JOIN
        dir_ida di ON di.id = dp.fk_saida
            LEFT JOIN
            ramais rm ON s.fk_id_ramais = rm.id
        $where
    GROUP BY s.id , data_solicitacao
    ORDER BY s.id asc";
        return $rawQuery;
    }

}
