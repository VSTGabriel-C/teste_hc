<?php

namespace App\Http\Controllers\Api\V_Solicitacoes;

use App\Http\Controllers\Controller;
use App\Models\Ch_destino;
use App\Models\DirGoing;
use App\Models\Direcao_volta;
use App\Models\Motorista;
use App\Models\Paciente;
use App\Models\Solicitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Sql;
use App\Models\Utensils;
use App\Models\Veiculo;

class Editar_Solicitacoes extends Controller
{
    public function editar_solicitacoes(Request $request, $id)
    {

        $msg = array();
        $ids = $this->getAll_by_Id($id);

        $nn = 0;
        $sql = new Sql();
        $retorno        = $request->retorno;
        $cancelamento   = $request->cancelamento;
        $sol_saida      = $request->sol_saida;
        $sol_km         = $request->sol_km;
        $nome_motor     = $request->mot_nome;
        $id_motorista   = $this->getMotoristaID($id);
        $tipo_carro     = $request->mot_carro;
        $id_veiculo     = $this->getVeiculoID($tipo_carro, $id);
        $response = DB::transaction(function () use($request, $id, $msg, $ids, $nn, $sql)
        {
            $nome_paciente  = $request->n_paciente;
            $ida            = $request->ida;
            $retorno        = $request->retorno;
            $cancelamento   = $request->cancelamento;
            $data_sol       = $request->data_sol;
            $hora_sol       = $request->hora_sol;
            $solic_nome     = $request->sol_nome;
            $ramal_sol      = $request->ramal_sol;
            $dest_sol       = $request->dest_sol;
            $port_sol       = $request->port_sol;
            $n_ficha_sol    = $request->n_ficha_sol;
            $end_loc_ident  = $request->end_loc_ident;
            $tipo_carro     = $request->mot_carro;
            $nome_motor     = $request->mot_nome;
            $sol_saida      = $request->sol_saida;
            $sol_km         = $request->sol_km;



            //PEGANDO DADOS HC INCOR RADIO

            $hc = $request->mot_HC;
            $incor = $request->mot_INCOR;
            $radio = $request->mot_radio;

            //LISTA DE UTENSILIOS

            $uti = $request->uti;
            $oxi = $request->oxi;
            $obe = $request->obe;
            $iso = $request->iso;
            $mac = $request->mac;
            $isolamento = $request->amb_isolamento;
            $iso_motivo = $request->amb_iso_qual;
            $obito = $request->amb_obito;

            //CONTATO PLANTÃO - SOLICITAÇÃO ATENDIDA POR

            $contato = $request->contato;
            $nome_func = $request->nome_func;

            $hora_chegada = $request->hora_chegada;
            $hora_retorno = $request->hora_retorno;
            $km_chegada = $request->km_chegada;
            $km_retorno = $request->km_retorno;


            $id_motorista   = $this->getMotoristaID($id);
            $id_solicitante = $this->getSolicitanteID($id);
            $id_veiculo     = $this->getVeiculoID($id);

            $confirmaKM_ch = $request->check_ch;
            $confirmaKM_vt = $request->check_vt;

            //UPDATE EM PACIENTE
            Paciente::where('id', '=', $ids['id_paciente'])->update(['nome_paciente' => Crypt::encryptString($nome_paciente)]);

            //UPDATE SOLICITAÇÃO
            Solicitation::where('id', '=', $id)->update(['going' => $ida,
            'return' => $retorno,
            'cancellation' => $cancelamento,
            'date' => $data_sol,
            'hour' => $hora_sol,
            'fk_applicant' => $id_solicitante->id,
            'fk_driver' => $id_motorista->id,
            'fk_vehicle' => $id_veiculo->id,
            'destiny'=> $dest_sol,
            'ordinance' => $port_sol,
            'n_file' => $n_ficha_sol,
            'end_loc_ident' => $end_loc_ident,
            'radio' => $radio,
            'hc' => $hc,
            'incor' => $incor,
            'contact_plant' =>  $contato,
            'attendance_by' => $nome_func]);

            Utensils::where('id', $ids['utencil_id'])->update([
                'oxygen' => $oxi,
                'obeso' => $obe,
                'isolete' => $iso,
                'stretcher' => $mac,
                'isolation' => $isolamento,
                'death' => $obito,
                'd_isolation' => $iso_motivo,
                'uti' => $uti,
            ]);


            // NAO TEM O MODELO DE UTENCILHO

            Utensils::where('id', $ids['utencil_id'])->update([
                'oxygen' => $oxi,
                'obese' => $obe,
                'isolete' => $iso,
                'stretcher' => $mac,
                'isolation' => $isolamento,
                'death' => $obito,
                'd_isolation' => $iso_motivo,
                'uti' => $uti,
            ]);

            $res = $sql->select("SELECT
            s.id,
            ifnull(ch.id, 0) AS chegada_id,
            ifnull(vt.id, 0) AS volta_id,
            IFNULL(ida.id,0) AS ida_id
            FROM
            solicitacao s
            LEFT JOIN dir_ch ch ON s.id = ch.fk_solicitation_ch
            LEFT JOIN dir_volta vt ON s.id = vt.fk_solicitation
            LEFT JOIN dir_ida ida ON s.id = ida.fk_solicitacao
            WHERE s.id = $id");

            foreach ($res as $key => $value)
            {
                $nn = $value;
            }

            if($nn['ida_id'] == 0 || $nn['ida_id'] == "")
            {
                DirGoing::create([
                    'hour' => $sol_saida,
                    'km' => $sol_km,
                    'fk_solicitation' => $id,
                ]);
            }else if($nn['ida_id'] != 0 || $nn['ida_id'] != "")
            {
                DirGoing::where('fk_solicitation', $id)->update([
                    'hour' => $sol_saida,
                    'km' => $sol_km,
                ]);
            }
            if($nn['chegada_id'] == 0 || $nn['chegada_id'] == "")
            {
                DB::insert("INSERT INTO dir_ch
                (horario, km, aviso_ch, fk_solicitation_ch)
                VALUES
                (?, ?, ?, ?)",
                [
                    $hora_chegada,
                    $km_chegada,
                    $confirmaKM_ch,
                    $id
                ]);
            }else if($nn['chegada_id'] != 0 || $nn['chegada_id'] != "")
            {
                Ch_destino::where('fk_solicitation_ch', $id)->update([
                    'horario' => $hora_chegada,
                    'km' => $km_chegada,
                    'aviso_ch' => $confirmaKM_ch,
                ]);
            }
            if($nn['volta_id'] == 0 || $nn['volta_id'] == "")
            {
                DB::insert("INSERT INTO dir_volta
                (horario, km, aviso_vt, fk_solicitation)
                VALUES
                (?, ?, ?, ?)",
                [
                    $hora_retorno,
                    $km_retorno,
                    $confirmaKM_vt,
                    $id
                ]);

            }else if($nn['volta_id'] != 0 || $nn['volta_id'] != "")
            {
                Direcao_volta::where('fk_solicitation', $id)->update([
                    'horario' => $hora_retorno,
                    'km' => $km_retorno,
                    'aviso_vt' => $confirmaKM_vt,
                ]);

            }


            return $msg = array(
                "status" => 1,
                "msg" => "Solicitação alterada com sucesso!"
            );

        });
        if($retorno == "OK" || $cancelamento == "OK")
        {
            $id_veic = $this->getVeiculoID($id);

            Motorista::where('id', $id_motorista->id)->update(['status' => 1]);

            Veiculo::where('id', $id_veic->id)->update(['status' => 1]);
        }
        else {

            $id_veic = $this->getVeiculoID($id);

            Motorista::where('id', $id_motorista->id)->update(['status' => 2]);

            Veiculo::where('id', $id_veic->id)->update(['status' => 2]);

        }

        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function getAll_by_Id($id)
    {
        $sql = new Sql();

        $exec = $sql->select("SELECT
        s.fk_utencilios AS utencil_id,
        p.id AS id_paciente,
        sol.id AS id_solicitante,
        m.id AS id_motorista,
        v.id AS id_veiculo,
        dp.id AS dist_perc_id
        FROM
        solicitacao s
        JOIN paciente p ON s.fk_paciente = p.id
        JOIN solicitante sol ON s.fk_solicitante = sol.id
        JOIN motorista m ON s.fk_motorista = m.id
        JOIN veiculo v ON s.fk_veiculo = v.id
        JOIN distancia_perc dp ON s.fk_dist_perc = dp.id
        WHERE s.id = $id");

        foreach($exec as $key => $value)
        {
            $new = $value;
        }

        return $new;

    }

    public function getMotoristaID($id)
    {
        $res = DB::select("SELECT
        m.id
        FROM
        solicitacao s
        JOIN  motorista m ON m.id = s.fk_motorista
        WHERE
        s.id = $id");

        foreach($res as $key => $value)
        {

            return $value;
        }

    }
    public function getVeiculoID($id)
    {
        $res = DB::select("SELECT
        v.id
        FROM
        solicitacao s
        JOIN  veiculo v ON v.id = s.fk_veiculo
        WHERE
        s.id = ?",
        [
            $id
        ]);

        foreach($res as $key => $value)
        {

            return $value;
        }
    }
    public function getSolicitanteID($id)
    {
        $res = DB::select("SELECT
        st.id
        FROM
        solicitacao s
        JOIN  solicitante st ON st.id = s.fk_solicitante
        WHERE
        s.id = ?",
        [
            $id
        ]);

        foreach($res as $key => $value)
        {

            return $value;
        }
    }

    public function getPacienteID($ids)
    {
        $resulta = DB::select("SELECT
        p.nome_paciente
        FROM
        paciente p
        WHERE
        p.id = ?",
        [
            $ids
        ]);

        foreach($resulta as $key => $value)
        {

            return $value;
        }
    }
}
