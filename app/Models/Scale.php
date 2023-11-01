<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Scale extends Model
{
    protected $fillable = ['identification', 'date_start', 'hour_start', 'hour_end', 'save', 'active'];

    public function vehicleScales()
    {
        return $this->hasMany(VehicleScale::class);
    }

    public function driverScales()
    {
        return $this->hasMany(DriverScale::class);
    }

    private $data_ok = [];

    public function newEscala(array $request)
    {
        if(count($request) == 0) return "error";

        $selects = null;

        $selects = $request['selects'];

        $mot_horarios = $request['horarios_mot'];
        if (empty(array_filter($mot_horarios, function($value) {
            return $value !== null;
        }))) return false;

        if (empty($selects[0]['motorista']) || empty($selects[0]['veiculos'])) return false;


        if(!isset($request['text_inputs'])) return false;

        $text_inputs = $request['text_inputs'];

        if(!isset($request['horarios_mot'])) return false;


        if(!isset($request['save'])) return false;

        $save = $request['save'];


        $resp = DB::transaction( function () use($selects, $text_inputs, $mot_horarios, $save){

            DB::beginTransaction();

            try {

                $response1 = Scale::create([
                    "identification" => $text_inputs[0],
                    "date_start" => Carbon::createFromFormat('d/m/Y', $text_inputs[1]),
                    "hour_start" => Carbon::createFromFormat('H:i', $text_inputs[2]),
                    "hour_end" => Carbon::createFromFormat('H:i', $text_inputs[3]),
                    "save" => $save,
                ]);

                array_push($this->data_ok, $response1 ? true : false);

                $last_id_scale = $response1->id;

                $drivers = array_map( function ($item)
                {
                    return $item['motorista'];
                }, $selects);

                $vehicles = array_map( function ($vehicle)
                {
                    return $vehicle['veiculos'];
                }, $selects);

                foreach($drivers as $key => $motorista)
                {

                    $driver_scale = DriverScale::create([
                        "hour_mot" => $mot_horarios[$key],
                        "fk_driver" => (int) $motorista,
                        "fk_scale" => $last_id_scale
                    ]);

                    array_push($this->data_ok, $driver_scale ? true : false);

                    foreach($vehicles[$key] as $vehicle)
                    {
                        $vehicle_scale = VehicleScale::create([
                            "fk_scale" => $last_id_scale,
                            "fk_driver" => (int) $drivers[$key],
                            "fk_vehicle" => (int) $vehicle
                        ]);

                        array_push($this->data_ok, $vehicle_scale ? true : false);
                    }
                }

                $check = true;
                foreach ($this->data_ok as $aux) {
                    if ($aux == false) {
                        $check = false;
                        break;
                    }
                }

                if($check)
                {
                    DB::commit();

                    return [
                        "code" => 200,
                        "status" => "success",
                        "msg" => "Nova scale registrada com sucesso!"
                    ];
                }

            }
            catch (Exception $ex)
            {

                dd($ex);
                die();
                return [
                    "code" => 500,
                    "status" => "error",
                    "msg" => "Erro ao registrar uma nova scale!"
                ];
            }


        });

        return $resp;
    }

    /**
     * Retorna todas as scales disponiveis
     *
     * @return array
     */
    public function getAllEscalas(): array
    {
        $scale = $this->all()->toArray();

        if(count($scale) <= 0) return [
            "code" => 500,
            "status" => "error",
            "msg" => "Nenhuma ". strtolower(class_basename(get_class($this))) ." foi escontrada"
        ];

        return $scale;
    }

    public function getAllEscalasByFilter(array $filters)
    {
        if(count($filters) > 1)
        {
            $scale = Scale::whereDate('scales.date_start', $filters['date_filter'])
            ->where('scales.active', $filters['active'])
            ->get()
            ->toArray();

            die();
        }

        $chave = (count($filters) > 0 ? array_keys($filters)[0] : null);

        switch($filters)
        {
            case 'date_filter':
                try
                {
                    $scale = Scale::whereDate('scales.date_start', $filters['date_filter'])
                    ->get()
                    ->toArray();

                    return $scale;
                }
                catch(Exception $ex)
                {
                    return [
                        "code" => 500,
                        "status" => "error",
                        "msg" => "erro ao buscar as scales com filtro!"
                    ];
                }
            break;
            case 'active':
                try
                {
                    $scale = Scale::where('scales.active', $filters['active'])
                    ->get()
                    ->toArray();

                    return $scale;
                }
                catch(Exception $ex)
                {
                    return [
                        "code" => 500,
                        "status" => "error",
                        "msg" => "erro ao buscar as scales com filtro!"
                    ];
                }

            break;
            default:
                return $this->getAllEscalas();
            break;
        }
    }


    public function getAllEscalasDataByFilter(array $request)
    {

        if (isset($request['id_escala'])) {
            if(in_array($request['id_escala'], $request))
            {

                $escalas_data = $this->filterEscala($request['id_escala'], $request['filters']);
                return $escalas_data;
            }
        }

        if(count($request) > 1)
        {
            $scale = $this::whereDate('date_start', $request['date_filter'])
            ->where('active', $request['active'])
            ->get()
            ->toArray();

            return $scale;
        }

        $chave = (count($request) > 0 && count($request) == 1? array_keys($request)[0] : null);

        switch($chave)
        {
            case 'date_filter':
                $scale = $this::whereDate('date_start', $request['date_filter'])
                ->get()
                ->toArray();

                return $scale;
            break;
            case 'active':
                $scale = $this::where('active', $request['active'])
                ->get()
                ->toArray();

                return $scale;
            break;
        }
    }

    /**
     * Função que retorna todos os dados da scale com filtro
     *
     * @param integer $id_escala
     * @param array $filters
     * @return array
     */
    private function filterEscala(int $id_escala, array $filters): array
    {

        try
        {
            if(count($filters) > 1)
            {
                /**
                 * Recuperando valores da Scale
                 */

                $scales = Scale::join('driver_scales', 'scales.id', '=', 'driver_scales.fk_scale')
                ->join('drivers AS m', 'm.id', '=', 'driver_scales.fk_driver')
                ->where('scales.id', $id_escala)
                ->whereDate('scales.date_start', $filters['date_filter'])
                ->where('scales.active', $filters['active'])
                ->orderBy('scales.id')
                ->select(
                    'm.name AS nome_motorista',
                    'escala_motorista.id AS id_escala_mot',
                    'scales.id AS id_escala',
                    'scales.active',
                    DB::raw('DATE(scales.date_start) AS date_start'),
                    DB::raw('TIME(scales.hour_start) AS hora_inicio'),
                    DB::raw('TIME(scales.hour_end) AS hora_fim'),
                    'scales.save AS salvar_escala',
                    'scales.identificacao',
                    'driver_scales.horario_mot'
                )
                ->get()
                ->toArray();

                $veiculos = Scale::join('vehicle_scales', 'scales.id', '=', 'vehicle_scales.fk_scale')
                ->join('vehicles AS v', 'v.id', '=', 'vehicle_scales.fk_vehicle')
                ->where('scales.id', '=', $id_escala)
                ->get([
                    'v.pref',
                    'v.id as veiculo_id',
                    'vehicle_scales.id AS id_escala_mot_veiculos',
                    'vehicle_scales.fk_driver AS pertence_a'
                ])
                ->toArray();

                foreach ($scales as $key => $scale) {
                    $motorista_id = $scale['id_motorista'];

                    $scale['veiculos'] = []; // Inicializa a chave 'veiculos' como um array vazio

                    foreach ($veiculos as $veiculo) {
                        if ($veiculo['pertence_a'] == $motorista_id) {
                            array_push($scale['veiculos'], $veiculo);
                        }
                    }

                    $scales[$key] = $scale; // Atualiza o elemento no array $scales
                }

                return $scales;
            }

            $chave = (count($filters) > 0 ? array_keys($filters)[0] : null);

            switch($chave)
            {
                case 'date_filter':
                    /**
                     * Recuperando valores da Scale
                     */

                    $scales = Scale::join('driver_scales', 'scales.id', '=', 'driver_scales.fk_scale')
                    ->join('drivers AS m', 'm.id', '=', 'driver_scales.fk_driver')
                    ->where('scales.id', $id_escala)
                    ->whereDate('scales.date_start', $filters[$chave])
                    ->orderBy('scales.id')
                    ->select(
                        'm.name AS nome_motorista',
                        'm.id AS id_motorista',
                        'scales.id AS id_escala',
                        'scales.active',
                        DB::raw('DATE(scales.date_start) AS date_start'),
                        DB::raw('TIME(scales.hour_start) AS hora_inicio'),
                        DB::raw('TIME(scales.hour_end) AS hora_fim'),
                        'scales.save AS salvar_escala',
                        'escala_motorista.id AS id_escala_mot',
                        'scales.identificacao',
                        'driver_scales.horario_mot'
                    )
                    ->get()
                    ->toArray();

                    $veiculos = Scale::join('vehicle_scales', 'scales.id', '=', 'vehicle_scales.fk_scale')
                    ->join('vehicles AS v', 'v.id', '=', 'vehicle_scales.fk_vehicle')
                    ->get([
                        'v.pref',
                        'vehicle_scales. id AS id_escala_mot_veiculos',
                        'v.id as veiculo_id',
                        'vehicle_scales.fk_driver AS pertence_a'
                    ])
                    ->toArray();

                    foreach ($scales as $key => $scale) {
                        $motorista_id = $scale['id_motorista'];

                        $scale['veiculos'] = []; // Inicializa a chave 'veiculos' como um array vazio

                        foreach ($veiculos as $veiculo) {
                            if ($veiculo['pertence_a'] == $motorista_id) {
                                array_push($scale['veiculos'], $veiculo);
                            }
                        }

                        $scales[$key] = $scale; // Atualiza o elemento no array $scales
                    }

                    return $scales;
                break;
                case 'active':
                    /**
                     * Recuperando valores da Scale
                     */

                    $scales = Scale::join('driver_scales', 'scales.id', '=', 'driver_scales.fk_scale')
                    ->join('drivers AS m', 'm.id', '=', 'driver_scales.fk_driver')
                    ->where('scales.id', $id_escala)
                    ->where('scales.active', $filters[$chave])
                    ->orderBy('scales.id')
                    ->select(
                        'm.name AS nome_motorista',
                        'm.id AS id_motorista',
                        'scales.id AS id_escala',
                        'scales.active',
                        DB::raw('DATE(scales.date_start) AS date_start'),
                        DB::raw('TIME(scales.hour_start) AS hora_inicio'),
                        DB::raw('TIME(scales.hour_end) AS hora_fim'),
                        'scales.save AS salvar_escala',
                        'escala_motorista.id AS id_escala_mot',
                        'scales.identificacao',
                        'driver_scales.horario_mot'
                    )
                    ->get()
                    ->toArray();

                    $veiculos = Scale::join('vehicle_scales', 'scales.id', '=', 'vehicle_scales.fk_scale')
                    ->join('vehicles AS v', 'v.id', '=', 'vehicle_scales.fk_vehicle')
                    ->get([
                        'v.pref',
                        'v.id as veiculo_id',
                        'vehicle_scales.id AS id_escala_mot',
                        'vehicle_scales.fk_driver AS pertence_a'
                    ])
                    ->toArray();

                    foreach ($scales as $key => $scale) {
                        $motorista_id = $scale['id_motorista'];

                        $scale['veiculos'] = []; // Inicializa a chave 'veiculos' como um array vazio

                        foreach ($veiculos as $veiculo) {
                            if ($veiculo['pertence_a'] == $motorista_id) {
                                array_push($scale['veiculos'], $veiculo);
                            }
                        }

                        $scales[$key] = $scale; // Atualiza o elemento no array $scales
                    }


                    return $scales;
                break;
                default:
                    /**
                     * Recuperando valores da Scale
                     */

                     $scales = Scale::join('driver_scales', 'scales.id', '=', 'driver_scales.fk_scale')
                     ->join('drivers AS m', 'm.id', '=', 'driver_scales.fk_driver')
                     ->where('scales.id', $id_escala)
                     ->orderBy('scales.id')
                     ->select(
                         'm.name AS nome_motorista',
                         'm.id AS id_motorista',
                         'scales.id AS id_escala',
                         'scales.active',
                         DB::raw('DATE(scales.date_start) AS date_start'),
                         DB::raw('TIME(scales.hour_start) AS hora_inicio'),
                         DB::raw('TIME(scales.hour_end) AS hora_fim'),
                         'scales.save AS salvar_escala',
                         'scales.identificacao',
                         'driver_scales.horario_mot',
                         'driver_scales.id as escala_moto_id'
                     )
                     ->get()
                     ->toArray();

                     $veiculos = Scale::join('vehicle_scales', 'scales.id', '=', 'vehicle_scales.fk_scale')
                     ->join('vehicles AS v', 'v.id', '=', 'vehicle_scales.fk_vehicle')
                     ->where('scales.id', $id_escala)
                     ->get([
                         'vehicle_scales.id as veiculo_mot_id',
                         'v.pref',
                         'v.id as veiculo_id',
                         'vehicle_scales.fk_driver AS pertence_a',
                         'vehicle_scales.observacao'
                     ])
                     ->toArray();

                     foreach ($scales as $key => $scale) {
                         $motorista_id = $scale['id_motorista'];

                         $scale['veiculos'] = []; // Inicializa a chave 'veiculos' como um array vazio

                         foreach ($veiculos as $veiculo) {
                             if ($veiculo['pertence_a'] == $motorista_id) {
                                 array_push($scale['veiculos'], $veiculo);
                             }
                         }

                         $scales[$key] = $scale; // Atualiza o elemento no array $scales
                     }


                     return $scales;
                break;
            }


        }
        catch(Exception $ex)
        {
            return [
                "code" => 500,
                "status" => "error",
                "msg" => "erro ao buscar as scales com filtro!"
            ];
        }

    }

    public function editEscala($scale)
    {

        $id_escala = $scale['fk_scale'];

        try
        {
            $escala_n = Scale::find($id_escala);

            if ($escala_n)
            {
                // Verifica se os valores existem antes de atribuí-los
                $dados_basicos = $scale['dados_basicos'];

                if (isset($dados_basicos['identificacao'])) {
                    $escala_n->identification = $dados_basicos['identificacao'][0];
                }
                if (isset($dados_basicos['dt_ini'])) {
                    $escala_n->date_start = Carbon::createFromFormat('d/m/Y', $dados_basicos['dt_ini'][0]);
                }

                if (isset($dados_basicos['hora_ini'])) {
                    $escala_n->hour_start = Carbon::createFromFormat('H:i:s', $dados_basicos['hora_ini'][0]);
                }

                if (isset($dados_basicos['hora_fim'])) {
                    $escala_n->hour_end = Carbon::createFromFormat('H:i:s', $dados_basicos['hora_fim'][0]);
                }

                $escala_n->save();
            } else
            {
                return false;
            }
        } catch (Exception $e)
        {
            return false;

        }
        return true;


    }
    public function activeDeactiveEscala($scale)
    {
        if(count($scale) <= 0) return [
            "code" => 500,
            "status" => "error",
            "msg" => "Nenhuma scale para alterar"
        ];

        $escala_id = $scale['id'];

        $escalas_ativas = $this->where("active", "=", 1)->get()->toArray();

        if(count($escalas_ativas) > 0 && count($escalas_ativas) == 1)
        {

            $data = $escalas_ativas[0];
            $this->id = $data['id'];
            $this->active = $data['active'];

            if($this->id == $escala_id && $this->active == 0)
            {
                $scale = $this::find($this->id);

                $scale->active = 1;

                $scale->save();

                return [
                    "code" => 200,
                    "status" => "success",
                    "msg" => "Status alterado com sucesso!"
                ];
            }
            else if($this->id == $escala_id && $this->active == 1)
            {
                $scale = $this::find($this->id);

                $scale->active = 0;

                $scale->save();

                return [
                    "code" => 200,
                    "status" => "success",
                    "msg" => "Status alterado com sucesso!"
                ];
            }
            else if($this->id != $escala_id && $this->active == 1)
            {

                $deactive = $this::find($this->id);

                $deactive->active = 0;

                $deactive->save();

                $scale = $this::find($escala_id);

                $scale->active = 1;

                $scale->save();

                return [
                    "code" => 200,
                    "status" => "success",
                    "msg" => "Status alterado com sucesso!"
                ];

            }
        }

        $scale = $this::find($escala_id);

        if($scale->active == 0)
        {
            try
            {
                $scale->active = 1;

                $scale->save();

                return [
                    "code" => 200,
                    "status" => "success",
                    "msg" => "Status alterado com sucesso!"
                ];

            }
            catch(Exception $ex)
            {
                return [
                    "code" => 500,
                    "status" => "success",
                    "msg" => "Erro ao alterar status!"
                ];
            }
        }

        try
        {
            $scale->active = 0;

            $scale->save();

            return [
                "code" => 200,
                "status" => "success",
                "msg" => "Status alterado com sucesso!"
            ];

        }
        catch(Exception $ex)
        {
            return [
                "code" => 500,
                "status" => "success",
                "msg" => "Erro ao alterar status!"
            ];
        }
    }

    public function editEscalasById()
    {

    }

    public function excludeEscalasById($id)
    {

        if(count($id) <= 0) return [
            "code" => 500,
            "status" => "error",
            "msg" => "Nenhum parametro foi passado!"
        ];

        $scale = $this::destroy($id['id']);

        if(!$scale)
        {
            return [
                "code" => 500,
                "status" => "error",
                "msg" => "Ocorreu um erro ao excluir a scale!"
            ];
        }

        return [
            "code" => 200,
            "status" => "success",
            "msg" => "Scale excluida com sucesso!"
        ];
    }

    public function verifyExpireEscala()
    {
        $scale = $this->whereDate('date_start', '=', date("Y-m-d"))
        ->get()
        ->toArray();

        foreach ($scale as $registro) {
            $hora_fim = strtotime($registro['hour_end']);
            $horaAtual = strtotime(date("Y-m-d H:i:s"));

            if ($hora_fim < $horaAtual && $registro['save'] == 0) {
                // Verificar a hora atual
                $this->verificarHoraAtual($registro['id']);
            }
        }
    }

    private function verificarHoraAtual($registroId) {
        $horaAtual = time();
        $registro = $this->find($registroId);

        if (strtotime($registro['hour_end']) < $horaAtual) {
            // Excluir o registro
            $registro->active = 0;
            $registro->save();
        }
    }


    public function retrieveMotoristaByEscalaActive()
    {
        $data_atual = date('Y-m-d');
        $hora_atual = date("H:i:s");

        try
        {
            /**
             * Fazer verificação de se existe uma scale ativa
             */
            $scale = $this::whereDate("date_start", $data_atual)
            ->where("active", "=", 1)
            ->get()
            ->toArray();

            if(count($scale) >= 1)
            {
                /**
                 * Retornar todos os motoristas da scale
                 */

                 $motoristas = $this::join('driver_scales', 'scales.id', '=', 'driver_scales.fk_scale')
                ->join('drivers AS m', 'm.id', '=', 'driver_scales.fk_driver')
                ->where('scales.id', $scale[0]['id'])
                ->select(
                    'm.name AS nome_motorista',
                    'm.id AS id_motorista'
                )
                ->get()
                ->toArray();

                return $motoristas;
            }

            return $scale;

        }
        catch(Exception $ex)
        {
            return [
                "code" => 500,
                "status" => "error",
                "msg" => "Erro ao tentar verificar motoristas da scale!"
            ];
        }

    }
    public function retrieveVeiculosByEscalaActive()
    {
        $data_atual = date('Y-m-d');
        $hora_atual = date("H:i:s");

        try
        {
            /**
             * Fazer verificação de se existe uma scale ativa
             */
            $scale = $this::whereDate("date_start", $data_atual)
            ->where("active", "=", 1)
            ->get()
            ->toArray();

            if(count($scale) >= 1)
            {
                /**
                 * Retornar todos os motoristas da scale
                 */

                 $veiculos = Scale::join('vehicle_scales', 'scales.id', '=', 'vehicle_scales.fk_scale')
                ->join('vehicles AS v', 'v.id', '=', 'vehicle_scales.fk_vehicle')
                ->where('scales.id', $scale[0]['id'])
                ->get([
                    'v.pref',
                    'v.id as veiculo_id',
                    'v.email',
                    'vehicle_scales.fk_driver AS pertence_a'
                ])
                ->toArray();

                $veiculosFiltrados = [];
                $prefExistente = [];

                foreach ($veiculos as $veiculo) {
                    $pref = $veiculo['pref'];
                    if (!in_array($pref, $prefExistente)) {
                        $veiculosFiltrados[] = $veiculo;
                        $prefExistente[] = $pref;
                    }
                }

                return $veiculosFiltrados;
            }

            return $scale;

        }
        catch(Exception $ex)
        {
            return [
                "code" => 500,
                "status" => "error",
                "msg" => "Erro ao tentar verificar motoristas da scale!"
            ];
        }

    }
}
