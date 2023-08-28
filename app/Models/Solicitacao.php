<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class Solicitacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'data',
        'hora',
        'origem',
        'destino',
        'portaria',
        'end_loc_ident',
        'fk_sol_ramal',
        'fk_paciente',
        'fk_motorista',
        'fk_veiculo'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function newSolicitation(Request $request)
    {
        $msg = array();
        $nome_motor     = $request->mot_nome;
        $motorista_id = $this->getMotoristaID($nome_motor);
        $tipo_carro     = $request->mot_carro;
        $carro_id = $this->getVeiculoID($tipo_carro);

        ///////////////////////////////////////////////////////////
        $ee = DB::transaction(function () use($request, $msg)
        {
            $nome_paciente = Crypt::encryptString($request->n_paciente);
            $ida            = $request->ida;
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
            $id_us          = $request->idUser;
            $escala_id      = $request->id_escala;

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

            // Observacao
            $observacao = $request->observacao;

            //METODOS QUE RECUPERAM ID
            $solicitante_id = $request->sol_id;
            $carro_id = $this->getVeiculoID($tipo_carro);
            $motorista_id = $this->getMotoristaID($nome_motor);
            $utencilID = $this->getUtencilID();
            $last = $this->getLast_Solicitation();


            //INSERINDO NOVO PACIENTE (NOME)
            $i_paciente = Paciente::create([
                'nome' => $nome_paciente
            ]);

            //CRIANDO NOVA SOLICITACAO
            Solicitacao::create([
                "data" => $data_sol,
                "hora" => $hora_sol,
                "destino" => $dest_sol,
                "portaria" => $port_sol,
                "end_loc_ident" => $end_loc_ident,
                "n_ficha" => $n_ficha_sol,
                "contato" => $contato,
                "atendida" => $nome_func,
                "observacao" => $observacao,
                "fk_escala" => $escala_id
            ]);

                //COLOCANDO IDA OU VOLTA
                if(!$ida)
                {
                    Solicitacao::where('id', '=', $last)->update(['ida' => 'NOK', 'retorno' => 'NOK']);
                }

                $i_solicitacao1 = Solicitacao::where('id', '=', $last)->update(['ida' => 'OK', 'retorno' => 'NOK', 'cancelamento' => 'NOK']);

                //INSERINDO HC INCOR e RADIO
                Solicitacao::where('id', '=', $last)->update(['incor' => $incor, 'radio' => $radio, 'fk_usuario' => $id_us]);

                //COLOCANDO CHAVE ESTRANGEIRA DO SOLICITANTE

                $i_solicitacao3 = Solicitacao::where('id', '=', $last)->update(['fk_solicitante' => $solicitante_id]);


                //COLOCANDO CHAVE ESTRANGEIRA DO VEICULO

                $i_solicitacao4 = Solicitacao::where('id', '=', $last)->update(['fk_veiculo' => $carro_id->id]);


                //COLOCANDO CHAVE ESTRANGEIRA DO MOTORISTA

                Solicitacao::where('id', '=', $last)->update(['fk_motorista' => $motorista_id->id]);

                //COLOCANDO UTENSILIOS

                V_utensilios::create([
                    'oxigenio' => $oxi,
                    'obeso' => $obe,
                    'isolete' => $iso,
                    'maca' => $mac,
                    'isolamento' => $isolamento,
                    'obito' => $obito,
                    'uti' => $uti,
                    'd_isolamento' => $iso_motivo,
                ]);

                $fk_solicitacao = $this->getLast_Solicitation();
                Direcao_ida::create([
                    'horario' => $sol_saida,
                    'km' => $sol_km,
                    'fk_solicitacao' => $fk_solicitacao,
                ]);

                $id_i = Direcao_ida::where("id", "=", $this->getLast_Direcao_ida())->select('id')->get();

                foreach($id_i as $key)
                {
                    $id_ida = $key->id;
                }

                $u_distancia_perc = Distancia_perc::create([
                    'fk_saida' => $id_ida
                ]);

                $id_d = Distancia_perc::orderBy('id', 'desc')->first();

                foreach($id_d as $key)
                {
                    $perc = $key->id;
                }

                Solicitacao::where('id', $this->getLast_Solicitation())->update('fk_dist_perc', $perc);

                $msg = [
                    'status' => 1,
                    'msg' => "Nova solicitação cadastrada com sucesso !"
                ];

                return json_encode($msg, JSON_UNESCAPED_UNICODE);

                });

                $utencilID2 = $this->getUtencilID();
                $last2 = $this->getLast_Solicitation();
                Solicitacao::where('id', $last2)->update('fk_utencilios', $utencilID2);

            //ALTERANDO O STATUS DO MOTORISTA

                Motorista::where('id', $motorista_id->id)->update('status', 2);

            //ALTERANDO O STATUS DO VEICULO

                Veiculo::where('id', $carro_id->id)->update('status', 2);

                $query2 = 1;

                        // NAO TEM O MODEL DE RAMAIS
                            $verf = DB::select("SELECT 1 FROM ramais rm WHERE rm.fk_solicitante_ramal = :sol_id",
                            [
                                ":sol_id" => $solicitante_id = $request -> sol_id
                            ]);

                        // NAO TEM O MODEL DE SOLICITANTE
                            $query1 = DB::select("SELECT 1 FROM solicitante st WHERE st.id = :sol_id AND st.ramal = :ramal_dig",
                            [
                                ":sol_id" => $solicitante_id = $request->sol_id,
                                ":ramal_dig" => $ramal_sol = $request->ramal_sol
                            ]);

                        // NAO TEM O MODEL DE RAMAIS
                            if(empty($query1)){
                                $query2 = DB::select("SELECT 1 FROM ramais rm WHERE rm.fk_solicitante_ramal = :sol_id AND rm.n_ramal = :ramal_dig",
                            [
                                ":sol_id" => $solicitante_id = $request->sol_id,
                                ":ramal_dig" => $ramal_sol = $request->ramal_sol
                            ]);
                        }
                            if(empty($query2)){
                                DB::insert('INSERT INTO ramais
                                (n_ramal,fk_solicitante_ramal)
                                values (:ramaldig, :idsolic)',
                                [
                                    ":ramaldig" => $ramal_sol = $request->ramal_sol,
                                    ":idsolic" => $solicitante_id = $request->sol_id
                                ]);
                            }


                        $idfk = 0;
                        $idset = null;
                        $idsetFK = 0;
                        $valor = 0;

                        $id_fk = DB::select("SELECT rm.id id FROM ramais rm WHERE rm.n_ramal = :ramal_dig",
                            [
                                ":ramal_dig" => $ramal_sol = $request->ramal_sol
                            ]);
                            if(!empty($id_fk)){
                                foreach ($id_fk as $key => $value)
                                {
                                    $idfk = $value;
                                }
                                    $idset = $idfk -> id;
                                    DB::update("UPDATE solicitacao s
                                    SET s.fk_id_ramais = :idfk
                                    WHERE s.id = :lastid",
                                    [
                                        ":idfk" => $idset,
                                        ":lastid" => $last = $this->getLast_Solicitation()
                                    ]);
                            }

             return $ee;
    }

    public function keyUser($id1, $id2)
    {

        User::where('id', $id2)->update('fk_solicitation', $id1);
    }

    public function getUtencilID()
    {
        $res = V_utensilios::orderBy('id', 'desc')->first();
        foreach ($res as $key)
        {
            return $id = $key->id;
        }
    }

    public function getVeiculoID($tipo)
    {

        $res = Veiculo::where('pref', $tipo)->select('id');

        foreach ($res as $key => $value)
        {
            return $id = $value;
        }
    }

    public function getMotoristaID($nome)
    {

        $res = Motorista::where('nome', $nome)->select('id');

        foreach ($res as $key => $value)
        {
            return $id = $value;
        }
    }

    public function getLast_Solicitation()
    {
        $res = Solicitacao::orderBy('id', 'desc')->first();
        foreach($res as $key)
        {
            return $id = $key->id;
        }
    }

    public function getLast_Direcao_ida()
    {
        $res = Direcao_ida::orderBy('id', 'desc')->first();
        foreach($res as $key)
        {
            return $id = $key->id;
        }
    }
}
