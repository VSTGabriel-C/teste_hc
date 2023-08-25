<?php
namespace App\Models;

date_default_timezone_set('America/Sao_Paulo');
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Escala extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "identificacao",
        "data_inicio",
        "hora_inicio",
        "hora_fim",
        "save",
        "active"
    ];

    private $data_ok = [];

    public $timestamps = false;

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
                //code...
                $response1 = DB::insert("INSERT INTO escalas (identificacao, data_inicio, hora_inicio, hora_fim, save)
                VALUES (:ident, :dt_ini, :hr_ini, :hr_fim, :save)",
                [
                    ":ident" => $text_inputs[0],
                    ":dt_ini" => Carbon::createFromFormat('d/m/Y', $text_inputs[1]),
                    ":hr_ini" => Carbon::createFromFormat('H:i', $text_inputs[2]),
                    ":hr_fim" => Carbon::createFromFormat('H:i', $text_inputs[3]),
                    ":save" => $save,
                ]);

                ($response1 ? array_push($this->data_ok, true) : array_push($this->data_ok, false));

                $last_id_escala = ( int ) DB::getPdo()->lastInsertId();

                $motoristas = array_map( function ($item)
                {
                    return $item['motorista'];
                }, $selects);

                $veiculos = array_map( function ($veiculo)
                {
                    return $veiculo['veiculos'];
                }, $selects);

                foreach($motoristas as $key => $motorista)
                {
                    $motorista_escala = DB::insert("INSERT INTO escala_motoristas (horario_mot, fk_motorista, fk_escala)
                    VALUES (:horario_mot, :motorista, :escala)
                    ",
                    [
                        ":horario_mot" => $mot_horarios[$key],
                        ":motorista" => (int) $motorista,
                        ":escala" => $last_id_escala
                    ]);

                    ($motorista_escala ? array_push($this->data_ok,true) : array_push($this->data_ok, false));

                    $last_id_escala_veiculo_motoristas = (int) DB::getPdo()->lastInsertId();

                    foreach($veiculos[$key] as $veiculo)
                    {

                        $veiculo_escala = DB::insert("INSERT INTO escala_motorista_veiculos (fk_escala, fk_motorista, fk_veiculo)
                        VALUES (:escala, :motorista, :veiculo)
                        ",
                        [
                            ":escala" => $last_id_escala,
                            ":motorista" => (int) $motoristas[$key],
                            ":veiculo" => (int) $veiculo
                        ]);

                        ($veiculo_escala ? array_push($this->data_ok, true) : array_push($this->data_ok, false));
                    }
                }

                $continue = false;

                foreach($this->data_ok as $ok)
                {
                    if(!$ok) return false;

                    $continue = true;
                }

                if($continue)
                {
                    DB::commit();

                    return [
                        "code" => 200,
                        "status" => "success",
                        "msg" => "Nova escala registrada com sucesso!"
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
                    "msg" => "Erro ao registrar uma nova escala!"
                ];
            }


        });

        return $resp;
    }

    /**
     * Retorna todas as escalas disponiveis
     *
     * @return array
     */
    public function getAllEscalas(): array
    {
        $escala = $this->all()->toArray();

        if(count($escala) <= 0) return [
            "code" => 500,
            "status" => "error",
            "msg" => "Nenhuma ". strtolower(class_basename(get_class($this))) ." foi escontrada"
        ];

        return $escala;
    }

    public function getAllEscalasByFilter(array $filters)
    {
        if(count($filters) > 1)
        {
            $escala = Escala::whereDate('escalas.data_inicio', $filters['date_filter'])
            ->where('escalas.active', $filters['active'])
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
                    $escala = Escala::whereDate('escalas.data_inicio', $filters['date_filter'])
                    ->get()
                    ->toArray();

                    return $escala;
                }
                catch(Exception $ex)
                {
                    return [
                        "code" => 500,
                        "status" => "error",
                        "msg" => "erro ao buscar as escalas com filtro!"
                    ];
                }
            break;
            case 'active':
                try
                {
                    $escala = Escala::where('escalas.active', $filters['active'])
                    ->get()
                    ->toArray();

                    return $escala;
                }
                catch(Exception $ex)
                {
                    return [
                        "code" => 500,
                        "status" => "error",
                        "msg" => "erro ao buscar as escalas com filtro!"
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
            $escala = $this::whereDate('data_inicio', $request['date_filter'])
            ->where('active', $request['active'])
            ->get()
            ->toArray();

            return $escala;
        }

        $chave = (count($request) > 0 && count($request) == 1? array_keys($request)[0] : null);

        switch($chave)
        {
            case 'date_filter':
                $escala = $this::whereDate('data_inicio', $request['date_filter'])
                ->get()
                ->toArray();

                return $escala;
            break;
            case 'active':
                $escala = $this::where('active', $request['active'])
                ->get()
                ->toArray();

                return $escala;
            break;
        }
    }

    /**
     * Função que retorna todos os dados da escala com filtro
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
                 * Recuperando valores da Escala
                 */

                $escalas = Escala::join('escala_motoristas', 'escalas.id', '=', 'escala_motoristas.fk_escala')
                ->join('motorista AS m', 'm.id', '=', 'escala_motoristas.fk_motorista')
                ->where('escalas.id', $id_escala)
                ->whereDate('escalas.data_inicio', $filters['date_filter'])
                ->where('escalas.active', $filters['active'])
                ->orderBy('escalas.id')
                ->select(
                    'm.nome AS nome_motorista',
                    'escala_motorista.id AS id_escala_mot',
                    'escalas.id AS id_escala',
                    'escalas.active',
                    DB::raw('DATE(escalas.data_inicio) AS data_inicio'),
                    DB::raw('TIME(escalas.hora_inicio) AS hora_inicio'),
                    DB::raw('TIME(escalas.hora_fim) AS hora_fim'),
                    'escalas.save AS salvar_escala',
                    'escalas.identificacao',
                    'escala_motoristas.horario_mot'
                )
                ->get()
                ->toArray();

                $veiculos = Escala::join('escala_motorista_veiculos', 'escalas.id', '=', 'escala_motorista_veiculos.fk_escala')
                ->join('veiculo AS v', 'v.id', '=', 'escala_motorista_veiculos.fk_veiculo')
                ->where('escalas.id', '=', $id_escala)
                ->get([
                    'v.pref',
                    'v.id as veiculo_id',
                    'escala_motorista_veiculos.id AS id_escala_mot_veiculos',
                    'escala_motorista_veiculos.fk_motorista AS pertence_a'
                ])
                ->toArray();

                foreach ($escalas as $key => $escala) {
                    $motorista_id = $escala['id_motorista'];

                    $escala['veiculos'] = []; // Inicializa a chave 'veiculos' como um array vazio

                    foreach ($veiculos as $veiculo) {
                        if ($veiculo['pertence_a'] == $motorista_id) {
                            array_push($escala['veiculos'], $veiculo);
                        }
                    }

                    $escalas[$key] = $escala; // Atualiza o elemento no array $escalas
                }

                return $escalas;
            }

            $chave = (count($filters) > 0 ? array_keys($filters)[0] : null);

            switch($chave)
            {
                case 'date_filter':
                    /**
                     * Recuperando valores da Escala
                     */

                    $escalas = Escala::join('escala_motoristas', 'escalas.id', '=', 'escala_motoristas.fk_escala')
                    ->join('motorista AS m', 'm.id', '=', 'escala_motoristas.fk_motorista')
                    ->where('escalas.id', $id_escala)
                    ->whereDate('escalas.data_inicio', $filters[$chave])
                    ->orderBy('escalas.id')
                    ->select(
                        'm.nome AS nome_motorista',
                        'm.id AS id_motorista',
                        'escalas.id AS id_escala',
                        'escalas.active',
                        DB::raw('DATE(escalas.data_inicio) AS data_inicio'),
                        DB::raw('TIME(escalas.hora_inicio) AS hora_inicio'),
                        DB::raw('TIME(escalas.hora_fim) AS hora_fim'),
                        'escalas.save AS salvar_escala',
                        'escala_motorista.id AS id_escala_mot',
                        'escalas.identificacao',
                        'escala_motoristas.horario_mot'
                    )
                    ->get()
                    ->toArray();

                    $veiculos = Escala::join('escala_motorista_veiculos', 'escalas.id', '=', 'escala_motorista_veiculos.fk_escala')
                    ->join('veiculo AS v', 'v.id', '=', 'escala_motorista_veiculos.fk_veiculo')
                    ->get([
                        'v.pref',
                        'escala_motorista_veiculos. id AS id_escala_mot_veiculos',
                        'v.id as veiculo_id',
                        'escala_motorista_veiculos.fk_motorista AS pertence_a'
                    ])
                    ->toArray();

                    foreach ($escalas as $key => $escala) {
                        $motorista_id = $escala['id_motorista'];

                        $escala['veiculos'] = []; // Inicializa a chave 'veiculos' como um array vazio

                        foreach ($veiculos as $veiculo) {
                            if ($veiculo['pertence_a'] == $motorista_id) {
                                array_push($escala['veiculos'], $veiculo);
                            }
                        }

                        $escalas[$key] = $escala; // Atualiza o elemento no array $escalas
                    }

                    return $escalas;
                break;
                case 'active':
                    /**
                     * Recuperando valores da Escala
                     */

                    $escalas = Escala::join('escala_motoristas', 'escalas.id', '=', 'escala_motoristas.fk_escala')
                    ->join('motorista AS m', 'm.id', '=', 'escala_motoristas.fk_motorista')
                    ->where('escalas.id', $id_escala)
                    ->where('escalas.active', $filters[$chave])
                    ->orderBy('escalas.id')
                    ->select(
                        'm.nome AS nome_motorista',
                        'm.id AS id_motorista',
                        'escalas.id AS id_escala',
                        'escalas.active',
                        DB::raw('DATE(escalas.data_inicio) AS data_inicio'),
                        DB::raw('TIME(escalas.hora_inicio) AS hora_inicio'),
                        DB::raw('TIME(escalas.hora_fim) AS hora_fim'),
                        'escalas.save AS salvar_escala',
                        'escala_motorista.id AS id_escala_mot',
                        'escalas.identificacao',
                        'escala_motoristas.horario_mot'
                    )
                    ->get()
                    ->toArray();

                    $veiculos = Escala::join('escala_motorista_veiculos', 'escalas.id', '=', 'escala_motorista_veiculos.fk_escala')
                    ->join('veiculo AS v', 'v.id', '=', 'escala_motorista_veiculos.fk_veiculo')
                    ->get([
                        'v.pref',
                        'v.id as veiculo_id',
                        'escala_motorista_veiculos.id AS id_escala_mot',
                        'escala_motorista_veiculos.fk_motorista AS pertence_a'
                    ])
                    ->toArray();

                    foreach ($escalas as $key => $escala) {
                        $motorista_id = $escala['id_motorista'];

                        $escala['veiculos'] = []; // Inicializa a chave 'veiculos' como um array vazio

                        foreach ($veiculos as $veiculo) {
                            if ($veiculo['pertence_a'] == $motorista_id) {
                                array_push($escala['veiculos'], $veiculo);
                            }
                        }

                        $escalas[$key] = $escala; // Atualiza o elemento no array $escalas
                    }


                    return $escalas;
                break;
                default:
                    /**
                     * Recuperando valores da Escala
                     */

                     $escalas = Escala::join('escala_motoristas', 'escalas.id', '=', 'escala_motoristas.fk_escala')
                     ->join('motorista AS m', 'm.id', '=', 'escala_motoristas.fk_motorista')
                     ->where('escalas.id', $id_escala)
                     ->orderBy('escalas.id')
                     ->select(
                         'm.nome AS nome_motorista',
                         'm.id AS id_motorista',
                         'escalas.id AS id_escala',
                         'escalas.active',
                         DB::raw('DATE(escalas.data_inicio) AS data_inicio'),
                         DB::raw('TIME(escalas.hora_inicio) AS hora_inicio'),
                         DB::raw('TIME(escalas.hora_fim) AS hora_fim'),
                         'escalas.save AS salvar_escala',
                         'escalas.identificacao',
                         'escala_motoristas.horario_mot',
                         'escala_motoristas.id as escala_moto_id'
                     )
                     ->get()
                     ->toArray();

                     $veiculos = Escala::join('escala_motorista_veiculos', 'escalas.id', '=', 'escala_motorista_veiculos.fk_escala')
                     ->join('veiculo AS v', 'v.id', '=', 'escala_motorista_veiculos.fk_veiculo')
                     ->where('escalas.id', $id_escala)
                     ->get([
                         'escala_motorista_veiculos.id as veiculo_mot_id',
                         'v.pref',
                         'v.id as veiculo_id',
                         'escala_motorista_veiculos.fk_motorista AS pertence_a',
                         'escala_motorista_veiculos.observacao'
                     ])
                     ->toArray();

                     foreach ($escalas as $key => $escala) {
                         $motorista_id = $escala['id_motorista'];

                         $escala['veiculos'] = []; // Inicializa a chave 'veiculos' como um array vazio

                         foreach ($veiculos as $veiculo) {
                             if ($veiculo['pertence_a'] == $motorista_id) {
                                 array_push($escala['veiculos'], $veiculo);
                             }
                         }

                         $escalas[$key] = $escala; // Atualiza o elemento no array $escalas
                     }


                     return $escalas;
                break;
            }


        }
        catch(Exception $ex)
        {
            return [
                "code" => 500,
                "status" => "error",
                "msg" => "erro ao buscar as escalas com filtro!"
            ];
        }

    }

    public function editEscala($escala)
    {

        $id_escala = $escala['fk_escala'];

        try
        {
            $escala_n = Escala::find($id_escala);

            if ($escala_n)
            {
                // Verifica se os valores existem antes de atribuí-los
                $dados_basicos = $escala['dados_basicos'];

                if (isset($dados_basicos['identificacao'])) {
                    $escala_n->identificacao = $dados_basicos['identificacao'][0];
                }
                if (isset($dados_basicos['dt_ini'])) {
                    $escala_n->data_inicio = Carbon::createFromFormat('d/m/Y', $dados_basicos['dt_ini'][0]);
                }

                if (isset($dados_basicos['hora_ini'])) {
                    $escala_n->hora_inicio = Carbon::createFromFormat('H:i:s', $dados_basicos['hora_ini'][0]);
                }

                if (isset($dados_basicos['hora_fim'])) {
                    $escala_n->hora_fim = Carbon::createFromFormat('H:i:s', $dados_basicos['hora_fim'][0]);
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
    public function activeDeactiveEscala($escala)
    {
        if(count($escala) <= 0) return [
            "code" => 500,
            "status" => "error",
            "msg" => "Nenhuma escala para alterar"
        ];

        $escala_id = $escala['id'];

        $escalas_ativas = $this->where("active", "=", 1)->get()->toArray();

        if(count($escalas_ativas) > 0 && count($escalas_ativas) == 1)
        {

            $data = $escalas_ativas[0];
            $this->id = $data['id'];
            $this->active = $data['active'];

            if($this->id == $escala_id && $this->active == 0)
            {
                $escala = $this::find($this->id);

                $escala->active = 1;

                $escala->save();

                return [
                    "code" => 200,
                    "status" => "success",
                    "msg" => "Status alterado com sucesso!"
                ];
            }
            else if($this->id == $escala_id && $this->active == 1)
            {
                $escala = $this::find($this->id);

                $escala->active = 0;

                $escala->save();

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

                $escala = $this::find($escala_id);

                $escala->active = 1;

                $escala->save();

                return [
                    "code" => 200,
                    "status" => "success",
                    "msg" => "Status alterado com sucesso!"
                ];

            }
        }

        $escala = $this::find($escala_id);

        if($escala->active == 0)
        {
            try
            {
                $escala->active = 1;

                $escala->save();

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
            $escala->active = 0;

            $escala->save();

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

        $escala = $this::destroy($id['id']);

        if(!$escala)
        {
            return [
                "code" => 500,
                "status" => "error",
                "msg" => "Ocorreu um erro ao excluir a escala!"
            ];
        }

        return [
            "code" => 200,
            "status" => "success",
            "msg" => "Escala excluida com sucesso!"
        ];
    }

    public function verifyExpireEscala()
    {
        $escala = $this->whereDate('data_inicio', '=', date("Y-m-d"))
        ->get()
        ->toArray();

        foreach ($escala as $registro) {
            $hora_fim = strtotime($registro['hora_fim']);
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

        if (strtotime($registro['hora_fim']) < $horaAtual) {
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
             * Fazer verificação de se existe uma escala ativa
             */
            $escala = $this::whereDate("data_inicio", $data_atual)
            ->where("active", "=", 1)
            ->get()
            ->toArray();

            if(count($escala) >= 1)
            {
                /**
                 * Retornar todos os motoristas da escala
                 */

                 $motoristas = $this::join('escala_motoristas', 'escalas.id', '=', 'escala_motoristas.fk_escala')
                ->join('motorista AS m', 'm.id', '=', 'escala_motoristas.fk_motorista')
                ->where('escalas.id', $escala[0]['id'])
                ->select(
                    'm.nome AS nome_motorista',
                    'm.id AS id_motorista'
                )
                ->get()
                ->toArray();

                return $motoristas;
            }

            return $escala;

        }
        catch(Exception $ex)
        {
            return [
                "code" => 500,
                "status" => "error",
                "msg" => "Erro ao tentar verificar motoristas da escala!"
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
             * Fazer verificação de se existe uma escala ativa
             */
            $escala = $this::whereDate("data_inicio", $data_atual)
            ->where("active", "=", 1)
            ->get()
            ->toArray();

            if(count($escala) >= 1)
            {
                /**
                 * Retornar todos os motoristas da escala
                 */

                 $veiculos = Escala::join('escala_motorista_veiculos', 'escalas.id', '=', 'escala_motorista_veiculos.fk_escala')
                ->join('veiculo AS v', 'v.id', '=', 'escala_motorista_veiculos.fk_veiculo')
                ->where('escalas.id', $escala[0]['id'])
                ->get([
                    'v.pref',
                    'v.id as veiculo_id',
                    'v.email',
                    'escala_motorista_veiculos.fk_motorista AS pertence_a'
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

            return $escala;

        }
        catch(Exception $ex)
        {
            return [
                "code" => 500,
                "status" => "error",
                "msg" => "Erro ao tentar verificar motoristas da escala!"
            ];
        }

    }

}
