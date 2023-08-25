<?php

namespace App\Http\Controllers\Api\Apis_Infos;
date_default_timezone_set('America/Sao_Paulo');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sql;

class V_informacoes extends Controller
{
    public function number_Solicitations()
    {
        $data_atual = date("Y-m-d");
        $ano_mes_atual = date("Y-m");
        // $req =$request->all();
        // $ano_inico = $req['inicio'];

        // $ano_mes_inico = `{$ano_inicio}-01`;
        $ano_mes_inico = "2022-01";
        $em_andamento = 0;
        $concluida = 0;
        $concluida_mes = 0;
        $cancelada = 0;
        $newArr = array();


        $queryQuilometragem = DB::select("SELECT DISTINCT
        COUNT(s.id) as total
    FROM
        solicitacao s
            LEFT JOIN
        dir_ch ch ON s.id = ch.fk_solicitation_ch
            LEFT JOIN
        dir_volta vt ON s.id = vt.fk_solicitation
    WHERE (ch.aviso_ch = 1 or vt.aviso_vt = 1);");

    $total = $queryQuilometragem[0];


        $solicitacao_dia = DB::select("SELECT
        distinct
        s.data AS data_solicitacao,
        COUNT(1) AS solicitacao_dia
        FROM
        solicitacao s
        WHERE CAST(s.data AS DATE) >= '{$data_atual}'
        AND CAST(s.data AS DATE) <= '{$data_atual}'
        GROUP BY  s.data");

        $solicitacao_ano = DB::select("SELECT
        distinct
        COUNT(s.id) AS solicitacoes_no_dia
        FROM
        solicitacao s
        WHERE
        s.retorno = 'OK'
        AND DATE_FORMAT(s.data,'%Y-%m')
        BETWEEN '$ano_mes_inico' AND '$ano_mes_atual'");

        $status = DB::select("SELECT
        s.retorno,
        s.cancelamento,
        s.ida
        FROM
        solicitacao s
        WHERE CAST(s.data AS DATE) >= '{$data_atual}'
        AND CAST(s.data AS DATE) <= '{$data_atual}'");


        if(count($solicitacao_dia) > 0 && count($status) > 0)
        {
            foreach($status as $key => $value)
            {
                if($value->retorno == "NOK" && $value->cancelamento == "NOK" && $value->ida == 'OK')
                {
                    $em_andamento = $em_andamento + 1;

                }else if($value->retorno == "OK" && $value->cancelamento == "NOK" )
                {
                    $concluida = $concluida + 1;
                }else if($value->retorno == "NOK" && $value->ida == 'NOK' && $value->cancelamento == "OK" )
                {
                    $cancelada = $cancelada + 1;
                }
            }
            $newArr[] = [
                "qtde_dia" => $solicitacao_dia[0]->solicitacao_dia,
                "qtde_concluida" => $concluida,
                "qtde_andamento" => $em_andamento,
                "qtde_cancelamento" => $cancelada,
                "qtde_quilometragem" => $total -> total,
            ];
        }else{
            $newArr[] = [
                "qtde_dia" => 0,
                "qtde_concluida" => $concluida,
                "qtde_andamento" => $em_andamento,
                "qtde_cancelamento" => $cancelada,
                "qtde_quilometragem" => $total -> total,
            ];
        }

        $newArr[0] += [
            "qtde_concluida_mes" => $solicitacao_ano[0]->solicitacoes_no_dia
        ];

        return json_encode($newArr);

    }
    public function number_SolicitationsPIE()
    {
        $newArrP = array();


        $retP = DB::select("SELECT
        COUNT(s.retorno) as retorno
        FROM
        solicitacao s
        WHERE s.retorno = 'OK'");

        $retornP = $retP['0'];

        $andP = DB::select("SELECT
        COUNT(s.ida) as andamento
        FROM
        solicitacao s
        WHERE s.retorno = 'NOK' AND s.cancelamento = 'NOK'");

        $andaP = $andP['0'];

        $cancP = DB::select("SELECT
        COUNT(s.cancelamento) as cancelamento
        FROM
        solicitacao s
        WHERE s.cancelamento = 'OK'");

        $cancelaP = $cancP['0'];

        if(!$cancelaP || !$andaP || !$retornP){
            $newArrP[] = [
                "qtde_concluidaP" =>0,
                "qtde_andamentoP" => 0,
                "qtde_cancelamentoP" => 0
            ];
        }else{
            $newArrP[] = [
                "qtde_concluidaP" => $retornP->retorno,
                "qtde_andamentoP" => $andaP->andamento,
                "qtde_cancelamentoP" => $cancelaP->cancelamento
            ];
        }

        return json_encode($newArrP);

    }



    public function mediaKilometragem()
    {
        $data_atual = date("Y-m-d");

        $minus_7_days = $this->seven_Days_Ant($data_atual);


        $sql = new Sql();

        $newArr = array();

        $response = $sql->select("SELECT
        COUNT(1) as QTDE,
        s.data as data,
        IFNULL(SUM(di.km), 0) AS inicial,
        IFNULL(SUM(ch.km), 0) AS chegada,
        IFNULL(SUM(dv.km), 0) AS volta,
        IFNULL((SUM(ch.km) - SUM(di.km))+(SUM(dv.km) - SUM(ch.km)), 0) AS Total
        FROM
        solicitacao s
        LEFT JOIN dir_ch ch ON ch.fk_solicitation_ch = s.id
        LEFT JOIN dir_volta dv ON dv.fk_solicitation = s.id
        LEFT JOIN distancia_perc dp ON dp.id = s.fk_dist_perc
        LEFT JOIN dir_ida di ON di.id = dp.fk_saida
        WHERE CAST(s.data AS DATE) >= '{$minus_7_days}'
        AND CAST(s.data AS DATE) <= '{$data_atual}'
        AND s.retorno = 'OK'
        GROUP BY CAST(s.data AS DATE)
        ORDER BY CAST(s.data AS DATE) LIMIT 8");


foreach($response as $key => $value)
   {
    // $media_dia = ($value['dia_T'] / $value['QTDE']);
    $newArr[$key] = [
        "dia_sem" => $this->day_Of_Week($value['data']),
        "total" => $value['Total']
    ];
   }

   return json_encode($newArr);

}
    public function card_dados_anual(Request $request)
    {
        $data_atual = date("Y-m-d");

        $ano_mes_atual = date("Y-m");
        $req =$request->all();
        $ano_mes_inico = $req['inicio'];
        // $ano_mes_inico = "2022-01";
        $ano_inicio = strtok($ano_mes_inico,'-');

        $sql = new Sql();

        $newArr = array();


        if(strtok($ano_mes_atual,'-') === "2021"){
            $response = $sql->select("SELECT
            MONTH(s.data) AS Mes,
            IFNULL(SUM(dv.km - di.km), 0) AS Total
            FROM
            solicitacao s
            LEFT JOIN dir_ch ch ON ch.fk_solicitation_ch = s.id
            LEFT JOIN dir_volta dv ON dv.fk_solicitation = s.id
            LEFT JOIN distancia_perc dp ON dp.id = s.fk_dist_perc
            LEFT JOIN dir_ida di ON di.id = dp.fk_saida
            WHERE DATE_FORMAT(s.data,'%Y-%m')
            BETWEEN '$ano_inicio-12' AND '$ano_inicio-12'
            AND s.retorno = 'OK' GROUP BY Mes");

            $response2['reali'] = $sql->select("SELECT
            distinct
            IFNULL(MONTH(s.data),0) AS Mes_realizadas,
            IFNULL(COUNT(s.id),0) AS solicitacoes_no_dia
            FROM
            solicitacao s
            WHERE DATE_FORMAT(s.data,'%Y-%m')
            BETWEEN '$ano_inicio-12' AND '$ano_inicio-12'
            AND s.retorno = 'OK' GROUP BY Mes_realizadas");
        }
        if(strtok($ano_mes_inico,'-') < strtok($ano_mes_atual,'-') && strtok($ano_mes_inico,'-') != '2019')
        {
            $response['quilo'] = $sql->select("SELECT
            MONTH(s.data) AS Mes,
            IFNULL(SUM(dv.km - ch.km), 0) AS Total
            FROM
            solicitacao s
            LEFT JOIN dir_ch ch ON ch.fk_solicitation_ch = s.id
            LEFT JOIN dir_volta dv ON dv.fk_solicitation = s.id
            LEFT JOIN distancia_perc dp ON dp.id = s.fk_dist_perc
            LEFT JOIN dir_ida di ON di.id = dp.fk_saida
            WHERE DATE_FORMAT(s.data,'%Y-%m')
            BETWEEN '$ano_mes_inico' AND '$ano_inicio-12'
            AND s.retorno = 'OK' GROUP BY Mes");

            $response2['reali'] = $sql->select("SELECT
            distinct
            IFNULL(MONTH(s.data),0) AS Mes_realizadas,
            IFNULL(COUNT(s.id),0) AS solicitacoes_no_dia
            FROM
            solicitacao s
            WHERE DATE_FORMAT(s.data,'%Y-%m')
            BETWEEN '$ano_mes_inico' AND '$ano_inicio-12'
            AND s.retorno = 'OK' GROUP BY Mes_realizadas");
        }
        else {
            $response['quilo'] = $sql->select("SELECT
            MONTH(s.data) AS Mes,
            IFNULL(SUM(dv.km - ch.km), 0) AS Total
            FROM
            solicitacao s
            LEFT JOIN dir_ch ch ON ch.fk_solicitation_ch = s.id
            LEFT JOIN dir_volta dv ON dv.fk_solicitation = s.id
            LEFT JOIN distancia_perc dp ON dp.id = s.fk_dist_perc
            LEFT JOIN dir_ida di ON di.id = dp.fk_saida
            WHERE DATE_FORMAT(s.data,'%Y-%m')
            BETWEEN '$ano_mes_inico' AND '$ano_mes_atual'
            AND s.retorno = 'OK' GROUP BY Mes");

            $response2['reali'] = $sql->select("SELECT
            distinct
            IFNULL(MONTH(s.data),0) AS Mes_realizadas,
            IFNULL(COUNT(s.id),0) AS solicitacoes_no_dia
            FROM
            solicitacao s
            WHERE
            s.retorno = 'OK'
            AND DATE_FORMAT(s.data,'%Y-%m')
            BETWEEN '$ano_mes_inico' AND '$ano_mes_atual' GROUP BY Mes_realizadas");
        }

   return json_encode(array_merge($response,$response2));

}

    private function seven_Days_Ant($data_atual)
    {
        $data_time = new \DateTime($data_atual);
        $intervalo = new \DateInterval("PT168H");
        $sub = $data_time->sub($intervalo);
        $dias_anteriores = $data_time->format("Y-m-d");

        return $dias_anteriores;
    }

    public function get_Concluidas(Request $request){

        $req =$request->all();
        $arr = [];
        $query  = $this->queryConcluidas($req['data']);
        $sql = new SQL();
        $exec = $sql->select($query);

        if(count($exec) > 0)
        {
            // $newValues = $this->to_utf8($exec);
            $newValues = $exec;
            //return json_encode($newValues, JSON_UNESCAPED_UNICODE);

            $arr[] = ['data' => $newValues];
            $smS = $arr;

		return json_encode($smS, JSON_UNESCAPED_UNICODE);
        }else
        {
            return json_encode($msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar solicitações concluidas na data de hoje."
            ), JSON_UNESCAPED_UNICODE);
        }

    }


    public function queryConcluidas($datP)
        {

        $rawQuery = "SELECT DISTINCT
        s.n_ficha AS n_ficha,
        sol.nome AS nome_solicitante,
        m.nome AS nome_motorista,
        s.destino AS destino,
        s.end_loc_ident AS ende,
        s.hora AS hora
    FROM
        solicitacao s
            LEFT JOIN
        motorista m ON s.fk_motorista = m.id
            LEFT JOIN
        solicitante sol ON s.fk_solicitante = sol.id
            LEFT JOIN
        veiculo v ON s.fk_veiculo = v.id
        WHERE s.data = '$datP' AND s.retorno = 'OK';" ;


        return $rawQuery;
    }
    public function get_Diarias(Request $request){

        $req =$request->all();
        $arr = [];
        $query  = $this->queryDiarias($req['data']);
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
                "msg"       => "Não foi possivel encontar solicitações na data de hoje."
            ), JSON_UNESCAPED_UNICODE);
        }

    }

    public function queryDiarias($datP)
    {

    $rawQuery = "SELECT DISTINCT
    s.n_ficha AS n_ficha,
    sol.nome AS nome_solicitante,
    m.nome AS nome_motorista,
    s.retorno,
    s.ida,
    IFNULL(s.cancelamento, 'NOK')AS cancelamento,
    s.destino AS destino,
    s.end_loc_ident AS ende,
    s.hora AS hora
    FROM
    solicitacao s
        LEFT JOIN
    motorista m ON s.fk_motorista = m.id
        LEFT JOIN
    solicitante sol ON s.fk_solicitante = sol.id
        LEFT JOIN
    veiculo v ON s.fk_veiculo = v.id
    WHERE s.data = '$datP';" ;


    return $rawQuery;
    }

    public function get_Andamento(Request $request){

        $req =$request->all();
        $arr = [];
        $query  = $this->queryAndamento($req['data']);
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
                "msg"       => "Não foi possivel encontar solicitações em andamento na data de hoje."
            ), JSON_UNESCAPED_UNICODE);
        }

    }

    public function get_CancelamentoModal(Request $request){

        $req =$request->all();
        $arr = [];
        $query  = $this->queryCancelamento($req['data']);
        $sql = new SQL();
        $exec = $sql->select($query);

        if(count($exec) > 0)
        {
            // $newValues = $this->to_utf8($exec);
            $newValues = $exec;
            //return json_encode($newValues, JSON_UNESCAPED_UNICODE);

            $arr[] = ['data' => $newValues];
            $smS = $arr;

        return json_encode($smS, JSON_UNESCAPED_UNICODE);
        }else
        {
            return json_encode($msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar solicitações canceladas na data de hoje."
            ), JSON_UNESCAPED_UNICODE);
        }

    }

    public function get_QuilometragemModal(Request $request){

        $arr = [];
        // $query  = $this->queryCancelamento($req['data']);]
        $query = "SELECT DISTINCT
            s.id,
            s.n_ficha AS numero_ficha,
            s.end_loc_ident AS End_Loc_ident,
            s.atendida_por,
            s.destino,
            s.`data` AS data_solicitacao,
            IFNULL(di.km, 0) AS sol_km,
            IFNULL(ch.km, 0) AS ch_kilometro,
            IFNULL(vt.km, 0) AS vt_kilometro
        FROM
            solicitacao s
                LEFT JOIN
            dir_ch ch ON s.id = ch.fk_solicitation_ch
                LEFT JOIN
            dir_volta vt ON s.id = vt.fk_solicitation
                LEFT JOIN
            distancia_perc dp ON dp.id = s.fk_dist_perc
                LEFT JOIN
            dir_ida di ON di.id = dp.fk_saida
        WHERE (ch.aviso_ch = 1 or vt.aviso_vt = 1)
        GROUP BY s.id , CAST(data_solicitacao AS DATE)
        ORDER BY s.id asc;";

        $sql = new SQL();
        $exec = $sql->select($query);

        if(count($exec) > 0)
        {
            $newValues = $exec;
            //return json_encode($newValues, JSON_UNESCAPED_UNICODE);

            $arr[] = ['data' => $newValues];
            $smS = $arr;

        return json_encode($smS, JSON_UNESCAPED_UNICODE);
        }else
        {
            return json_encode($msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar solicitações com alta quilometragem."
            ), JSON_UNESCAPED_UNICODE);
        }

    }

    public function get_Cancelamentos()
    {
        $data_atualL = date("Y-m-d");

        $minus_7_daysL = $this->seven_Days_Ant($data_atualL);

        $queryCanc  = "SELECT s.data,COUNT(1) AS CANCELADAS FROM solicitacao s WHERE s.cancelamento = 'OK' AND s.data between '$minus_7_daysL' and '$data_atualL' GROUP BY s.data ORDER BY s.data ASC;";

        $sql = new SQL();
        $Canceladas = $sql->select($queryCanc);


        $queryConc  = "SELECT s.data,COUNT(s.retorno) as FEITAS FROM solicitacao s WHERE (retorno = 'OK' OR cancelamento = 'OK') AND s.data BETWEEN '$minus_7_daysL' AND '$data_atualL' group by s.data order by s.data ASC;";
        $sql2 = new SQL();
        $Concluidas = $sql2->select($queryConc);

        if(!$Canceladas){
            $Canceladas[] = ['data' => $data_atualL, 'CANCELADAS' => 0];
        }
        if(!$Concluidas){
            $Concluidas[] = ['data' => $data_atualL, 'FEITAS' => 0];
        }

        foreach($Concluidas as $key => $value)
        {
            $datasF[]=$value['data'];
            $feitas[] = $value['FEITAS'];
        }
        foreach($Canceladas as $key2 => $value2)
        {
            $datasC[]=$value2['data'];
            $canc[] = $value2['CANCELADAS'];
        }
        $arr[] = ['datasC' => $datasC, 'feitasF' => $feitas,'datasFull' => $datasF, 'Canc' => $canc];

    return json_encode($arr, JSON_UNESCAPED_UNICODE);

    }

    // public function isnull($var, $default=null) {
    //     return is_null($var) ? $default : $var;
    // }
    public function queryCancelamento($datP)
    {

    $rawQuery = "SELECT DISTINCT
    s.n_ficha AS n_ficha,
    sol.nome AS nome_solicitante,
    m.nome AS nome_motorista,
    s.destino AS destino,
    s.end_loc_ident AS ende,
    s.hora AS hora
    FROM
    solicitacao s
        LEFT JOIN
    motorista m ON s.fk_motorista = m.id
        LEFT JOIN
    solicitante sol ON s.fk_solicitante = sol.id
        LEFT JOIN
    veiculo v ON s.fk_veiculo = v.id
    WHERE s.data = '$datP' AND s.retorno = 'NOK' AND s.ida = 'NOK' AND s.cancelamento = 'OK';" ;


    return $rawQuery;
    }

    public function queryAndamento($datP)
    {

    $rawQuery = "SELECT DISTINCT
    s.n_ficha AS n_ficha,
    sol.nome AS nome_solicitante,
    m.nome AS nome_motorista,
    s.destino AS destino,
    s.end_loc_ident AS ende,
    s.hora AS hora
    FROM
    solicitacao s
        LEFT JOIN
    motorista m ON s.fk_motorista = m.id
        LEFT JOIN
    solicitante sol ON s.fk_solicitante = sol.id
        LEFT JOIN
    veiculo v ON s.fk_veiculo = v.id
    WHERE s.data = '$datP' AND s.retorno = 'NOK' AND s.cancelamento = 'NOK';" ;


    return $rawQuery;
    }

    private function day_Of_Week($day)
    {
        $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');

        $diasemana_numero = date('w', strtotime($day));

    return $day_week = $diasemana[$diasemana_numero];
    }

    private function to_utf8($data)
    {
    $newArr = array();
    foreach($data as $key => $value){
        if(count($value) == 6)
        {
            foreach($data as $key2 => $value2)
            {
                $newArr[$key2] = [
                'n_ficha' => utf8_encode($value2['n_ficha']),
                'nome_solicitante' => utf8_encode($value2['nome_solicitante']),
                'nome_motorista' => utf8_encode($value2['nome_motorista']),
                'destino' => utf8_encode($value2['destino']),
                'ende' => utf8_encode($value2['ende']),
                'hora' => utf8_encode($value2['hora'])
                ];
            }
        }
         else if(count($value) == 9)
            {
                foreach($data as $key2 => $value2)
                {
                    $newArr[$key2] = [
                    'n_ficha' => utf8_encode($value2['n_ficha']),
                    'nome_solicitante' => utf8_encode($value2['nome_solicitante']),
                    'nome_motorista' => utf8_encode($value2['nome_motorista']),
                    'retorno' => utf8_encode($value2['retorno']),
                    'ida' => utf8_encode($value2['ida']),
                    'cancelamento' => utf8_encode($value2['cancelamento']),
                    'destino' => utf8_encode($value2['destino']),
                    'ende' => utf8_encode($value2['ende']),
                    'hora' => utf8_encode($value2['hora'])
                    ];
                }
            }
    }
    return $newArr;
    }

}
