<?php

namespace App\Http\Controllers\Api\Apis_Infos;

date_default_timezone_set('America/Sao_Paulo');

use App\Http\Controllers\Controller;
use App\Models\Solicitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sql;
use Carbon\Carbon;

class V_informacoes extends Controller
{
    public function number_Solicitations()
    {
        $data_atual = date("Y-m-d");
        $ano_mes_inico = "2022-01";
        $em_andamento = 0;
        $concluida = 0;
        $cancelada = 0;

        $queryQuilometragem = Solicitation::select('solicitations.id AS total')
            ->join('dir_ch AS ch', 'ch.fk_solicitation', '=', 'solicitations.id')
            ->join('dir_return AS rt', 'rt.fk_solicitation', '=', 'solicitations.id')
            ->where('ch.warning_ch', 1)->orWhere('rt.warning_return', 1)
            ->count();

        $total = $queryQuilometragem;

        $solicitacao_dia = Solicitation::whereDate("date", $data_atual)->count();

        $solicitacao_ano = Solicitation::where("return", "OK")
            ->whereDate("date", ">=", $ano_mes_inico)
            ->whereDate("date", "<=", $data_atual)
            ->count();

        $status = Solicitation::where("date", $data_atual)->select('return', 'cancellation', 'going')->get();

        if ($solicitacao_dia > 0 && count($status) > 0) {
            foreach ($status as $key => $value) {
                if ($value->return == "NOK" && $value->cancellation == "NOK" && $value->going == 'OK') {
                    $em_andamento = $em_andamento + 1;
                } else if ($value->return == "OK" && $value->cancellation == "NOK") {
                    $concluida = $concluida + 1;
                } else if ($value->return == "NOK" && $value->going == 'NOK' && $value->cancellation == "OK") {
                    $cancelada = $cancelada + 1;
                }
            }
            $newArr[] = [
                "qtde_dia" => $solicitacao_dia,
                "qtde_concluida" => $concluida,
                "qtde_andamento" => $em_andamento,
                "qtde_cancelamento" => $cancelada,
                "qtde_quilometragem" => $total,
            ];
        } else {
            $newArr[] = [
                "qtde_dia" => 0,
                "qtde_concluida" => $concluida,
                "qtde_andamento" => $em_andamento,
                "qtde_cancelamento" => $cancelada,
                "qtde_quilometragem" => $total,
            ];
        }

        $newArr[0] += [
            "qtde_concluida_ano" => $solicitacao_ano
        ];

        return json_encode($newArr);
    }

    public function number_SolicitationsPIE()
    {
        $retP = Solicitation::where("return", "OK")->select('return')->count();

        $andP = Solicitation::where("return", 'NOK')->where('cancellation', 'NOK')->select('going')->count();

        $cancP = Solicitation::where("cancellation", 'OK')->select('cancellation')->count();

        $newArrP[] = [
            "qtde_concluidaP" => $retP,
            "qtde_andamentoP" => $andP,
            "qtde_cancelamentoP" => $cancP
        ];

        return json_encode($newArrP);
    }

    public function mediaKilometragem()
    {
        $data_atual = date("Y-m-d");
        $minus_7_days = $this->seven_Days_Ant($data_atual); // tira 7 dias

        $response = Solicitation::from('solicitations AS s')
            ->selectRaw('COUNT(1) AS QTDE,
                s.date AS date,IFNULL(SUM(di.km), 0) AS inicial,
                IFNULL(SUM(ch.km), 0) AS chegada,
                IFNULL(SUM(dv.km), 0) AS volta,
                IFNULL((SUM(ch.km) - SUM(di.km)) + (SUM(dv.km) - SUM(ch.km)), 0) AS Total')
            ->leftJoin('dir_ch AS ch', 'ch.fk_solicitation', '=', 's.id')
            ->leftJoin('dir_return AS dv', 'dv.fk_solicitation', '=', 's.id')
            ->leftJoin('distance_percs AS dp', 'dp.id', '=', 's.fk_dist_perc')
            ->leftJoin('dir_goings AS di', 'di.id', '=', 'dp.fk_dir_going')
            ->whereDate('s.date', '>=', $minus_7_days)
            ->whereDate('s.date', '<=', $data_atual)
            ->where('s.return', 'OK')
            ->groupBy('s.date')
            ->orderBy('s.date')
            ->take(8)
            ->get();

        foreach ($response as $key => $value) {
            $newArr[$key] = [
                "dia_sem" => $this->day_Of_Week($value->date),
                "total" => $value->Total,
            ];
        }
        return json_encode($newArr);
    }
    // public function card_dados_anual(Request $request)
    // {
    //     $ano_mes_atual = date("Y-m");
    //     $ano_mes_inicio = $request->inicio;
    //     $ano_inicio = strtok($ano_mes_inicio, '-');

    //     if (strtok($ano_mes_atual, '-') === "2023") {
    //         $response = DB::select("SELECT
    //         DAY(s.date) AS Mes,
    //         IFNULL(SUM(dv.km - di.km), 0) AS Total
    //         FROM
    //         solicitations s
    //         LEFT JOIN dir_ch ch ON ch.fk_solicitation = s.id
    //         LEFT JOIN dir_return dv ON dv.fk_solicitation = s.id
    //         LEFT JOIN distance_percs dp ON dp.id = s.fk_dist_perc
    //         LEFT JOIN dir_goings di ON di.id = dp.fk_dir_going
    //         WHERE DATE_FORMAT(s.date,'%Y-%m')
    //         BETWEEN '$ano_inicio-12' AND '$ano_inicio-12'
    //         AND s.return = 'OK' GROUP BY Mes");

    //         dd($response);

    //         $response2['reali'] = $sql->select("SELECT
    //         distinct
    //         IFNULL(MONTH(s.data),0) AS Mes_realizadas,
    //         IFNULL(COUNT(s.id),0) AS solicitacoes_no_dia
    //         FROM
    //         solicitacao s
    //         WHERE DATE_FORMAT(s.data,'%Y-%m')
    //         BETWEEN '$ano_inicio-12' AND '$ano_inicio-12'
    //         AND s.retorno = 'OK' GROUP BY Mes_realizadas");
    //     }
    //     if (strtok($ano_mes_inicio, '-') < strtok($ano_mes_atual, '-') && strtok($ano_mes_inicio, '-') != '2019') {
    //         $response['quilo'] = $sql->select("SELECT
    //         MONTH(s.data) AS Mes,
    //         IFNULL(SUM(dv.km - ch.km), 0) AS Total
    //         FROM
    //         solicitacao s
    //         LEFT JOIN dir_ch ch ON ch.fk_solicitation_ch = s.id
    //         LEFT JOIN dir_volta dv ON dv.fk_solicitation = s.id
    //         LEFT JOIN distancia_perc dp ON dp.id = s.fk_dist_perc
    //         LEFT JOIN dir_ida di ON di.id = dp.fk_saida
    //         WHERE DATE_FORMAT(s.data,'%Y-%m')
    //         BETWEEN '$ano_mes_inicio' AND '$ano_inicio-12'
    //         AND s.retorno = 'OK' GROUP BY Mes");

    //         $response2['reali'] = $sql->select("SELECT
    //         distinct
    //         IFNULL(MONTH(s.data),0) AS Mes_realizadas,
    //         IFNULL(COUNT(s.id),0) AS solicitacoes_no_dia
    //         FROM
    //         solicitacao s
    //         WHERE DATE_FORMAT(s.data,'%Y-%m')
    //         BETWEEN '$ano_mes_inicio' AND '$ano_inicio-12'
    //         AND s.retorno = 'OK' GROUP BY Mes_realizadas");
    //     } else {
    //         $response['quilo'] = $sql->select("SELECT
    //         MONTH(s.data) AS Mes,
    //         IFNULL(SUM(dv.km - ch.km), 0) AS Total
    //         FROM
    //         solicitacao s
    //         LEFT JOIN dir_ch ch ON ch.fk_solicitation_ch = s.id
    //         LEFT JOIN dir_volta dv ON dv.fk_solicitation = s.id
    //         LEFT JOIN distancia_perc dp ON dp.id = s.fk_dist_perc
    //         LEFT JOIN dir_ida di ON di.id = dp.fk_saida
    //         WHERE DATE_FORMAT(s.data,'%Y-%m')
    //         BETWEEN '$ano_mes_inicio' AND '$ano_mes_atual'
    //         AND s.retorno = 'OK' GROUP BY Mes");

    //         $response2['reali'] = $sql->select("SELECT
    //         distinct
    //         IFNULL(MONTH(s.data),0) AS Mes_realizadas,
    //         IFNULL(COUNT(s.id),0) AS solicitacoes_no_dia
    //         FROM
    //         solicitacao s
    //         WHERE
    //         s.retorno = 'OK'
    //         AND DATE_FORMAT(s.data,'%Y-%m')
    //         BETWEEN '$ano_mes_inicio' AND '$ano_mes_atual' GROUP BY Mes_realizadas");
    //     }

    //     return json_encode(array_merge($response, $response2));
    // }

    private function seven_Days_Ant($data_atual)
    {
        $data_time = new \DateTime($data_atual);
        $intervalo = new \DateInterval("PT168H");
        $data_time->sub($intervalo);
        $dias_anteriores = $data_time->format("Y-m-d");

        return $dias_anteriores;
    }

    public function get_Concluidas(Request $request)
    {
        $exec = Solicitation::from('solicitations AS s')
            ->select(
                's.n_file AS n_ficha',
                'sol.name AS nome_solicitante',
                'm.name AS nome_motorista',
                's.destiny AS destino',
                's.end_loc_ident AS ende',
                's.hour AS hora'
            )
            ->leftJoin('drivers AS m', 's.fk_driver', '=', 'm.id')
            ->leftJoin('applicants AS sol', 's.fk_applicant', '=', 'sol.id')
            ->leftJoin('vehicles AS v', 's.fk_vehicle', '=', 'v.id')
            ->where('s.date', $request->data)
            ->where('s.return', 'OK')
            ->get();

        if (count($exec) > 0) {
            $newValues = $exec;
            $arr[] = ['data' => $newValues];
            $smS = $arr;

            return json_encode($smS, JSON_UNESCAPED_UNICODE);
        } else {
            $msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar solicitações concluidas na data de hoje."
            );
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
    }

    public function get_Diarias(Request $request)
    {
        $exec = Solicitation::from('solicitations AS s')
            ->selectRaw("s.n_file AS n_ficha,
            sol.name AS nome_solicitante,
            m.name AS nome_motorista,
            s.return,
            s.going,
            IFNULL(s.cancellation, 'NOK') AS cancelamento,
            s.destiny AS destino,
            s.end_loc_ident AS ende,
            s.hour AS hora")
            ->leftJoin('drivers AS m', 's.fk_driver', '=', 'm.id')
            ->leftJoin('applicants AS sol', 's.fk_applicant', '=', 'sol.id')
            ->leftJoin('vehicles AS v', 's.fk_vehicle', '=', 'v.id')
            ->where('s.date', $request->data)
            ->get();

        if (count($exec) > 0) {
            $newValues = $exec;

            $arr[] = ['data' => $newValues];
            $smS = $arr;

            return json_encode($smS, JSON_UNESCAPED_UNICODE);
        } else {
            $msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar solicitações na data de hoje."
            );
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
    }

    public function get_Andamento(Request $request)
    {

        $exec = Solicitation::from('solicitations AS s')
            ->select('s.n_file AS n_ficha', 'sol.name AS nome_solicitante', 'm.name AS nome_motorista', 's.destiny AS destino', 's.end_loc_ident AS ende', 's.hour AS hora')
            ->leftJoin('drivers AS m', 's.fk_driver', '=', 'm.id')
            ->leftJoin('applicants AS sol', 's.fk_applicant', '=', 'sol.id')
            ->leftJoin('vehicles AS v', 's.fk_vehicle', '=', 'v.id')
            ->where('s.date', $request->data)
            ->where('s.return', 'NOK')
            ->where('s.cancellation', 'NOK')
            ->get();

        if (count($exec) > 0) {
            $newValues = $exec;

            $arr[] = ['data' => $newValues];
            $smS = $arr;

            return json_encode($smS, JSON_UNESCAPED_UNICODE);
        } else {
            $msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar solicitações em andamento na data de hoje."
            );
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
    }

    public function get_CancelamentoModal(Request $request)
    {
        $exec = Solicitation::from('solicitations AS s')
            ->select(
                's.n_file AS n_ficha',
                'sol.name AS nome_solicitante',
                'm.name AS nome_motorista',
                's.destiny AS destino',
                's.end_loc_ident AS ende',
                's.hour AS hora'
            )
            ->leftJoin('drivers AS m', 's.fk_driver', '=', 'm.id')
            ->leftJoin('applicants AS sol', 's.fk_applicant', '=', 'sol.id')
            ->leftJoin('vehicles AS v', 's.fk_vehicle', '=', 'v.id')
            ->where('s.date', $request->data)
            ->where('s.return', 'NOK')
            ->where('s.going', 'NOK')
            ->where('s.cancellation', 'OK')
            ->get();

        if (count($exec) > 0) {
            $newValues = $exec;

            $arr[] = ['data' => $newValues];
            $smS = $arr;

            return json_encode($smS, JSON_UNESCAPED_UNICODE);
        } else {
            $msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar solicitações canceladas na data de hoje."
            );
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
    }

    public function get_QuilometragemModal()
    {
        $exec = Solicitation::from('solicitations AS s')
            ->selectRaw(
                "s.id,
                s.n_file AS numero_ficha,
                s.end_loc_ident AS End_Loc_ident, s.attendance_by,
                s.destiny, s.date AS data_solicitacao,
                IFNULL(di.km, 0) AS sol_km,
                IFNULL(ch.km, 0) AS ch_kilometro,
                IFNULL(vt.km, 0) AS vt_kilometro"
            )
            ->leftJoin('dir_ch AS ch', 's.id', '=', 'ch.fk_solicitation')
            ->leftJoin('dir_return AS vt', 's.id', '=', 'vt.fk_solicitation')
            ->leftJoin('distance_percs AS dp', 'dp.id', '=', 's.fk_dist_perc')
            ->leftJoin('dir_goings AS di', 'di.id', '=', 'dp.fk_dir_going')
            ->where('ch.warning_ch', 1)->orWhere('vt.warning_return', 1)
            ->groupBy('s.id', 'data_solicitacao', 'numero_ficha', 'End_Loc_ident', 's.attendance_by', 's.destiny', 'di.km', 'ch.km', 'vt.km')
            ->orderBy('s.id', 'asc')
            ->get();

        if (count($exec) > 0) {
            $newValues = $exec;

            $arr[] = ['data' => $newValues];
            $smS = $arr;

            return json_encode($smS, JSON_UNESCAPED_UNICODE);
        } else {
            $msg = array(
                "status"    => 0,
                "msg"       => "Não foi possivel encontar solicitações com alta quilometragem."
            );
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
    }

    public function get_Cancelamentos()
    {
        $data_atualL = date("Y-m-d");

        $minus_7_daysL = $this->seven_Days_Ant($data_atualL);

        $Canceladas = Solicitation::selectRaw("date, COUNT(*) AS CANCELADAS")
            ->where('cancellation', 'OK')
            ->whereBetween('date', [$minus_7_daysL, $data_atualL])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $Concluidas = Solicitation::selectRaw("date, COUNT(solicitations.return) AS FEITAS")
            ->where('cancellation', 'OK')->orWhere('return', 'OK')
            ->whereBetween('date', [$minus_7_daysL, $data_atualL])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        if (!$Canceladas) {
            $Canceladas[] = ['data' => $data_atualL, 'CANCELADAS' => 0];
        }
        if (!$Concluidas) {
            $Concluidas[] = ['data' => $data_atualL, 'FEITAS' => 0];
        }

        foreach ($Concluidas as $key => $value) {
            $datasF[] = $value->date;
            $feitas[] = $value->FEITAS;
        }
        foreach ($Canceladas as $key2 => $value2) {
            $datasC[] = $value2->date;
            $canc[] = $value2->CANCELADAS;
        }

        $arr[] = ['datasC' => $datasC, 'feitasF' => $feitas, 'datasFull' => $datasF, 'Canc' => $canc];

        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    private function day_Of_Week($day)
    {
        $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');

        $diasemana_numero = date('w', strtotime($day));

        return $diasemana[$diasemana_numero];
    }
}
