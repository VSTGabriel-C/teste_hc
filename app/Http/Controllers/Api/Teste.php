<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Sql;

class Teste extends Controller
{
    public function teste(Request $request)
    {
        $sql = new Sql();
        // $diaI  = $request   ->   dataini;
        // $diaF  = $request   ->   datafim;
        // $horaI = $request   ->   horaini;
        // $horaF = $request   ->   horafim;
        $diaI  ="2022-01-01";
        $diaF  ="2022-01-30";
        $horaI ='';
        $horaF = '';

        if(!$horaI or !$horaF){
            $horaI = '00:00';
            $horaF = '23:50';
        }

        $newArr = array();
        $response = $sql->select("SELECT DISTINCT
        p.nome_paciente,
        m.nome AS motorista_nome,
        v.pref AS veiculo_pref,
        v.placa,
        v.tipo,
        s.end_loc_ident AS instituo,
        s.`data` AS data_solicitacao,
        di.horario AS hora_inicio,
        IFNULL(vt.horario, 0) AS hora_final
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
            dir_volta vt ON s.id = vt.fk_solicitation
                LEFT JOIN
            distancia_perc dp ON dp.id = s.fk_dist_perc
                LEFT JOIN
            dir_ida di ON di.id = dp.fk_saida
        WHERE
            s.`retorno` = 'OK' AND s.`data` BETWEEN '$diaI' and '$diaF'
            AND s.hora between '{$horaI}' AND '{$horaF}'
        GROUP BY s.id , CAST(data_solicitacao AS DATE)
        ORDER BY s.`data`");

        foreach ($response as $key => $value) {
            $response[$key]['nome_paciente'] = Crypt::decryptString($response[$key]['nome_paciente']);
        }


    $html = '';
    $html .= '<table border="1">';
    $html .= '<tr>';
    $html .= "<td colspan='5'>DADOS HC</tr>";
    $html .= '</tr>';


    $html .= '<tr>';
    $html .= '<td><b>Nome Paciente</b></td>';
    $html .= '<td><b>Motorista</b></td>';
    $html .= '<td><b>Veiculo</b></td>';
    $html .= '<td><b>Placa do Veiculo</b></td>';
    $html .= '<td><b>Tipo do Veiculo</b></td>';
    $html .= '<td><b>Instituo</b></td>';
    $html .= '<td><b>Data do Transporte</b></td>';
    $html .= '<td><b>Hora de Inicio</b></td>';
    $html .= '<td><b>Hora do Fim</b></td>';
    $html .= '</tr>';

    foreach($response as $key => $value)
    {
        $html .= "<tr>";
        $html .= "<td style='text-align: center; vertical-align: middle'>".$value["nome_paciente"]."</td>";
        $html .= "<td style='text-align: center; vertical-align: middle'>".$value["motorista_nome"]."</td>";
        $html .= "<td style='text-align: center; vertical-align: middle'>".$value["veiculo_pref"]."</td>";
        $html .= "<td style='text-align: center; vertical-align: middle'>".$value["placa"]."</td>";
        $html .= "<td style='text-align: center; vertical-align: middle'>".$value["tipo"]."</td>";
        $html .= "<td style='text-align: center; vertical-align: middle'>".$value["instituo"]."</td>";
        $html .= "<td style='text-align: center; vertical-align: middle'>".$value["data_solicitacao"]."</td>";
        $html .= "<td style='text-align: center; vertical-align: middle'>".$value["hora_inicio"]."</td>";
        $html .= "<td style='text-align: center; vertical-align: middle'>".$value["hora_final"]."</td>";
        $html .= "</tr>";
    }

    $str = mb_convert_encoding($html, "HTML-ENTITIES", "UTF-8");
    $arquivo = 'Relatorio-HC.xls';
    header('Content-Type: application/vnd.openxmlformats- officedocument.spreadsheetml.sheet');
    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header('Cache-Control: max-age=0');


    echo $str;
    die();
    exit;


        $diaI = $request ->dataini;
        $diaF = $request ->datafim;
        $horaI = $request ->horaini;
        $HoraF = $request ->horafim;
        $instituto1 = $request -> inst1;
        $instituto2 = $request -> inst2;
        $instituto3 = $request -> inst3;



        $response = $sql->select("SELECT
        COUNT(1) as QTDE,
        s.data,
        SUM(dv.km - ch.km) as dia_T
        FROM solicitacao s
        JOIN dir_ch ch ON s.id = ch.fk_solicitation_ch
        JOIN dir_volta dv ON s.id = dv.fk_solicitation
        WHERE s.data between '{$diaI}' AND '{$diaF}'
        AND s.hora between '{$horaI}' AND '{$HoraF}'
        group by s.data");



        $response1 = $sql->select ("SELECT
        COUNT(1) as QTDE,
        SUM(dv.km - ch.km) as dia_T
        FROM solicitacao s
        JOIN dir_ch ch ON s.id = ch.fk_solicitation_ch
        JOIN dir_volta dv ON s.id = dv.fk_solicitation
        WHERE s.data between '{$diaI}' AND '{$diaF}'
        AND s.hora between '{$horaI}' AND '{$HoraF}'
        ;");



        if($instituto1 =! ''){
            $Ins1 = $instituto1 = $request -> inst1;
            $inst1selectConc = $sql->select("SELECT
            COUNT(1) AS cont_inst1
            FROM solicitacao s
            WHERE LOWER(s.destino) LIKE LOWER('%{$Ins1}%')
            AND s.retorno = 'OK'
            AND s.data between '{$diaI}' AND '{$diaF}'
            AND s.hora between '{$horaI}' AND '{$HoraF}'
            ;");

            $inst1selectCanc = $sql->select("SELECT
            COUNT(1) AS cont_inst1
            FROM solicitacao s
            WHERE LOWER(s.destino) Like LOWER('%{$Ins1}%')
            AND s.cancelamento = 'OK'
            AND s.data between '{$diaI}' AND '{$diaF}'
            AND s.hora between '{$horaI}' AND '{$HoraF}'
            ;");

            $qtdeInst1Conc = $inst1selectConc['0']['cont_inst1'];
            $qtdeInst1Canc = $inst1selectCanc['0']['cont_inst1'];

        }else{
            $qtdeInst1Conc = '0';
            $qtdeInst1Canc = '0';
        }

        if($Inst2 =! ''){
            $Ins2 = $instituto2 = $request -> inst2;
            $inst2selectConc = $sql->select("SELECT
            COUNT(1) AS cont_inst2
            FROM solicitacao s
            WHERE LOWER(s.destino) Like LOWER('%{$Ins2}%')
            AND s.retorno = 'OK'
            AND s.data between '{$diaI}' AND '{$diaF}'
            AND s.hora between '{$horaI}' AND '{$HoraF}'
            ;");

            $inst2selectCanc = $sql->select("SELECT
            COUNT(1) AS cont_inst2
            FROM solicitacao s
            WHERE LOWER(s.destino) Like LOWER('%{$Ins2}%')
            AND s.cancelamento = 'OK'
            AND s.data between '{$diaI}' AND '{$diaF}'
            AND s.hora between '{$horaI}' AND '{$HoraF}'
            ;");

            $qtdeInst2Conc = $inst2selectConc['0']['cont_inst2'];
            $qtdeInst2Canc = $inst2selectCanc['0']['cont_inst2'];

        }else{
            $qtdeInst2Conc = '0';
            $qtdeInst2Canc = '0';
        }

        if($Inst3 =! ''){
            $Ins3 = $instituto3 = $request -> inst3;
            $inst3selectConc = $sql->select("SELECT
            COUNT(1) AS cont_inst3
            FROM solicitacao s
            WHERE LOWER(s.destino) Like LOWER('%{$Ins3}%')
            AND s.retorno = 'OK'
            AND s.data between '{$diaI}' AND '{$diaF}'
            AND s.hora between '{$horaI}' AND '{$HoraF}'
            ;");

            $inst3selectCanc = $sql->select("SELECT
            COUNT(1) AS cont_inst3
            FROM solicitacao s
            WHERE LOWER(s.destino) Like LOWER('%{$Ins3}%')
            AND s.cancelamento = 'OK'
            AND s.data between '{$diaI}' AND '{$diaF}'
            AND s.hora between '{$horaI}' AND '{$HoraF}'
            ;");

            $qtdeInst3Conc = $inst3selectConc['0']['cont_inst3'];
            $qtdeInst3Canc = $inst3selectCanc['0']['cont_inst3'];

        }else{
            $qtdeInst3Conc = '0';
            $qtdeInst3Canc = '0';
        }



      $dia_T = $response1['0']['dia_T'];
      $Qtde_T = $response1['0']['QTDE'];
      $media_T = $dia_T / $Qtde_T;


      foreach($response as $key => $value)
      {
          $media_dia = ($value['dia_T'] / $value['QTDE']);
          $newArr[$key] = [
              "DIA" => $value['data'],
              "media_dia" => Round($media_dia),
            ];

        }

        $contArrMT = count($newArr);
        $newArr[$contArrMT] = [
            "Media_T" =>Round($media_T)
        ];
        $contArrI1 = count($newArr);
        $newArr[$contArrI1 ] = [
            "Concluidas_{$Ins1}" =>$qtdeInst1Conc,
            "Canceladas_{$Ins1}" =>$qtdeInst1Canc
        ];
        $contArrI2 = count($newArr);
        $newArr[$contArrI2 ] = [
            "Concluidas_{$Ins2}" =>$qtdeInst2Conc,
            "Canceladas_{$Ins2}" =>$qtdeInst2Canc
        ];
        $contArrI3 = count($newArr);
        $newArr[$contArrI3 ] = [
            "Concluidas_{$Ins3}" =>$qtdeInst3Conc,
            "Canceladas_{$Ins3}" =>$qtdeInst3Canc
        ];

        dd($newArr);
        die();


    }
}
