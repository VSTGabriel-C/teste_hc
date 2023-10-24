<?php

namespace App\Models;

use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class Solicitation extends Model
{
    use HttpResponses;

    protected $fillable = [
        'date',
        'hour',
        'destiny',
        'ordinance',
        'end_loc_ident',
        'going',
        'return',
        'cancellation',
        'n_file',
        'hc',
        'incor',
        'radio',
        'contact_plant',
        'attendance_by',
        'observation',
        'status_sol',
        'fk_user',
        'fk_ramal',
        'fk_applicant',
        'fk_utensil',
        'fk_vehicle',
        'fk_driver',
        'fk_dist_perc',
        'fk_patient'
    ];

    private $data_create = [];
    private $data_update = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function utensils()
    {
        return $this->belongsTo(Utensils::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dirGoings()
    {
        return $this->belongsTo(DirGoing::class);
    }

    public function dirChs()
    {
        return $this->belongsTo(DirCh::class);
    }

    public function dirReturns()
    {
        return $this->belongsTo(DirReturn::class);
    }

    public function distancePercs()
    {
        return $this->belongsTo(DistancePerc::class);
    }

    public function ramal()
    {
        return $this->belongsTo(Ramal::class);
    }

    public function getAllSolicitations()
    {

        $response = Solicitation::orderBy("id", "asc")->get();
        $arr = ['data' => $response];
        $sm = $arr;
        return json_encode($sm, JSON_UNESCAPED_UNICODE);
    }

    public function newSolicitation(Request $request)
    {
        //DADOS DA SOLICITAÇÂO
        $ficha = Solicitation::where('n_file', $request->n_ficha_sol)->first();
        if ($ficha) {
            $msg = [
                "status" => 0,
                "msg" => "Não foi possivel cadastrar uma nova solicitação N° da ficha já existe !"
            ];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
        $ee = DB::transaction(function () use ($request) {
            DB::beginTransaction();

            $nome_paciente = Crypt::encryptString($request->n_paciente);

            //METODOS QUE RECUPERAM ID
            $carro_id = $this->getVeiculoID($request->mot_carro);
            $motorista_id = $this->getMotoristaID($request->mot_nome);

            //INSERINDO NOVO PACIENTE (NOME)
            $i_paciente = Patient::create([
                'patient_name' => $nome_paciente
            ]);
            array_push($this->data_create, $i_paciente ? true : false);

            $last_patient = $i_paciente->id;

            //CRIANDO NOVA SOLICITACAO
            $newSolicitation = Solicitation::create([
                "date" => $request->data_sol,
                "hour" => $request->hora_sol,
                "destiny" => $request->dest_sol,
                "ordinance" => $request->port_sol,
                "end_loc_ident" => $request->end_loc_ident,
                "n_file" => $request->n_ficha_sol,
                "contact_plant" => $request->contato,
                "attendance_by" => $request->nome_func,
                "observation" => $request->observacao,
                "hc" => $request->mot_HC,
                "status_sol" => 1,
                "fk_scale" => $request->id_escala
            ]);

            array_push($this->data_create, $newSolicitation ? true : false);

            $last_solicitation = $newSolicitation->id;

            //COLOCANDO IDA OU VOLTA
            if (!$request->ida) {
                $up_going = Solicitation::where('id', '=', $last_solicitation)->update(['going' => 'NOK', 'return' => 'NOK']);
                array_push($this->data_update, $up_going ? true : false);
            }
            $up_going = Solicitation::where('id', '=', $last_solicitation)->update([
                'going' => 'OK',
                'return' => 'NOK',
                'cancellation' => 'NOK'
            ]);
            array_push($this->data_update, $up_going ? true : false);

            //INSERINDO HC INCOR e RADIO
            $up_incor = Solicitation::where('id', '=', $last_solicitation)->update([
                'incor' => $request->mot_INCOR,
                'radio' => $request->mot_radio,
                'fk_user' => $request->idUser
            ]);
            array_push($this->data_update, $up_incor ? true : false);

            //COLOCANDO CHAVE ESTRANGEIRA DO SOLICITANTE
            $up_fk_applicant = Solicitation::where('id', '=', $last_solicitation)->update(['fk_applicant' => $request->sol_id]);
            array_push($this->data_update, $up_fk_applicant ? true : false);

            //COLOCANDO CHAVE ESTRANGEIRA DO VEICULO
            $up_fk_vehicle = Solicitation::where('id', '=', $last_solicitation)->update(['fk_vehicle' => $carro_id]);
            array_push($this->data_update, $up_fk_vehicle ? true : false);

            //COLOCANDO CHAVE ESTRANGEIRA DO MOTORISTA
            $up_fk_driver = Solicitation::where('id', '=', $last_solicitation)->update(['fk_driver' => $motorista_id]);
            array_push($this->data_update, $up_fk_driver ? true : false);

            // COLOCANDO PACIENTE
            $up_fk_patient = Solicitation::where('id', '=', $last_solicitation)->update(['fk_patient' => $last_patient]);
            array_push($this->data_update, $up_fk_patient ? true : false);

            //COLOCANDO UTENSILIOS
            $newUtensils = Utensils::create([
                'oxygen' => $request->oxi,
                'obese' => $request->obe,
                'isolate' => $request->iso,
                'stretcher' => $request->mac,
                'isolation' => $request->amb_isolamento,
                'death' => $request->amb_obito,
                'uti' => $request->uti,
                'd_isolation' => $request->amb_iso_qual,
            ]);
            array_push($this->data_create, $newUtensils ? true : false);

            $last_Utensil = $newUtensils->id;

            $newDirGoing = DirGoing::create([
                'hour' => $request->sol_saida,
                'km' => $request->sol_km,
                'fk_solicitation' => $last_solicitation,
            ]);
            array_push($this->data_create, $newDirGoing ? true : false);

            $last_DirGoing = $newDirGoing->id;

            $u_distancia_perc = DistancePerc::create([
                'fk_dir_going' => $last_DirGoing
            ]);
            array_push($this->data_create, $u_distancia_perc ? true : false);

            $last_DistancePerc = $u_distancia_perc->id;

            //COLOCANDO CHAVE ESTRANGEIRA DA DISTANCIA PERCORRIDA
            $up_fk_dist_perc = Solicitation::where('id', $last_solicitation)->update(['fk_dist_perc' => $last_DistancePerc]);
            array_push($this->data_update, $up_fk_dist_perc ? true : false);

            //COLOCANDO CHAVE ESTRANGEIRA DOS UTENCILIOS
            $up_fk_utensil = Solicitation::where('id', $last_solicitation)->update(['fk_utensil' => $last_Utensil]);
            array_push($this->data_update, $up_fk_utensil ? true : false);

            //ALTERANDO O STATUS DO MOTORISTA
            $up_driver_status = Driver::where('id', $motorista_id)->update(['status' => 2]);
            array_push($this->data_update, $up_driver_status ? true : false);

            //ALTERANDO O STATUS DO VEICULO
            $up_vehicle_status = Vehicle::where('id', $carro_id)->update(['status' => 2]);
            array_push($this->data_update, $up_vehicle_status ? true : false);

            $query2 = 1;

            $query1 = Applicant::where('id', $request->sol_id)              // verifica se existe alguem com este ramal
                ->where('ramal', $request->ramal_sol)
                ->first();

            if (empty($query1)) {                             // se n tiver, ele vai verificar
                $query2 = Ramal::where('fk_applicant', $request->sol_id)    // se existe este ramal com este solicitante
                    ->where('n_ramal', $request->ramal_sol)
                    ->first();
            }

            if (empty($query2)) {                                  // se n existir, ele cria um Ramal para o solicitante
                $newRamal = Ramal::create([
                    "n_ramal" => $request->ramal_sol,
                    "fk_applicant" => $request->sol_id
                ]);
                array_push($this->data_create, $newRamal ? true : false);
            }

            $id_fk = Ramal::where("n_ramal", $request->ramal_sol)->select('id')->first();

            //COLOCANDO CHAVE ESTRANGEIRA DO RAMAL
            if (!empty($id_fk)) {
                $up_kf_ramal = Solicitation::where('id', $last_solicitation)->update(['fk_ramal' => $id_fk->id]);
                array_push($this->data_update, $up_kf_ramal ? true : false);
            }

            $check = true;
            foreach ($this->data_create as $aux) {
                if ($aux == false) {
                    $check = false;
                    break;
                }
            }

            foreach ($this->data_update as $aux) {
                if ($aux == false) {
                    $check = false;
                    break;
                }
            }

            if ($check == true) {
                DB::commit();
            }

            if ($check == false) {
                DB::rollBack();
            }

            $msg = [
                'status' => 1,
                'msg' => "Nova solicitação cadastrada com sucesso!"
            ];

            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        });
        return $ee;
    }

    public function keyUser($id1, $id2)
    {
        User::where('id', $id2)->update(['fk_solicitation' => $id1]);
    }

    public function getVeiculoID($tipo)
    {
        $res = Vehicle::where('pref', $tipo)->select("id")->first();
        return $res->id;
    }

    public function getMotoristaID($nome)
    {

        $res = Driver::where('name', $nome)->select('id')->first();
        return $res->id;
    }
}
