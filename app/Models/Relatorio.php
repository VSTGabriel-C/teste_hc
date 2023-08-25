<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use App\Models\Sql;
use App\Models\ModelsGS;

class Relatorio extends ModelsGS
{

    private $tipos_relatorio = array();



    public function __construct($request)
    {
        $this->sql = new Sql();
        $this->listRelatorio = $this->setlist_Relatorio($request);
    }

    public function get_Data_Rel()
    {

    }
    public function gerar_Xls()
    {
        $params  = $this->getlist_Relatorio();
        if(!$params['rel_type']){
            dd("AQUI1");
            die();
            $msg = [
                'status' => 0,
                'msg' => "Tipo de relátorio não informado!"
            ];
        }
        if($params['rel_type'] != 'Atendimentos Realizados'){
            dd("AQUI2");
            die();
            $msg = [
                'status' => 0,
                'msg' => "Não foi criado esse tipo de relátorio no momento"
            ];
        }
        $diaI = $params['data_ini'];
        $diaF  = $params['data_fim'];
        $horaI = $params['hora_ini'];
        $horaF = $params['hora_fim'];


        $time_input_I = strtotime($diaI);
        $mouth_ini = date('m',$time_input_I);

        $time_input_F = strtotime($diaF);
        $mouth_fim = date('m',$time_input_F);

        $year_ini = date('Y',$time_input_I);
        $year_fim = date('Y',$time_input_F);

        if($year_fim < "2022" or $year_ini < "2022"){
            dd("AQUI1");
            die();
            $msg = [
                'status' => 0,
                'msg' => "Não foi gerado relátorio para esse ano!"
            ];

            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }

        if($mouth_ini!=$mouth_fim and $mouth_ini>$mouth_fim){
            $msg = [
                'status' => 0,
                'msg' => "Mês Inicial maior que o mês final!"
            ];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
        if($diaI > $diaF){
            $msg = [
                'status' => 0,
                'msg' => "Data Inicial maior que a final!"
            ];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
        if(!$diaI or !$diaF){
            $msg = [
                'status' => 0,
                'msg' => "Data de pesquisa não inserida!"
            ];

            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
        if(!$horaI or !$horaF){
            $horaI = '00:00';
            $horaF = '23:59';
        }
        $response = $this->sql->select("SELECT DISTINCT
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
        ORDER BY s.`data`, di.horario");

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
    }

    public function rel_Generate()
    {

    }
}
