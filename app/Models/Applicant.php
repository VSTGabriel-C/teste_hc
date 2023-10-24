<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Applicant extends Model
{
    protected $fillable = ['matriculation', 'ramal', 'name', 'email', 'h_d', 'motive'];

    public function ramals()
    {
        return $this->hasMany(Ramal::class);
    }

    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }

    public function getApplicant()
    {

        $res = Applicant::orderBy("id", "asc")->get();

        $arr = ['data' => $res];
        $sm = $arr;
        return json_encode($sm, JSON_UNESCAPED_UNICODE);
    }

    public function getApplicantS()
    {
        $res = Applicant::get();

        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function getApplicant_condition()
    {
        $res = Applicant::orderBy('name')->get();

        foreach ($res as $key)
        {
            if($key->h_d == 1)
            {
                $lista[] = [$key];
            }else
            {
                $lista[] = [];
            }
        }

        return json_encode($lista);
    }

    public function getApplicantById($id)
    {
        $response = Applicant::where("id", $id)->select("matriculation", "ramal", "name", "email")->get();

        return json_encode($response);
    }

    public function newApplicant(Request $request)
    {
        $n_mat = $request->cod;
        $ramal = $request->ramal;
        $name = $request->nome;
        $email = $request->email;

        $val = Applicant::where("matriculation", $n_mat)->first();

        if ($val)
        {
            $msg = [
                'status' => 0,
                'msg' => "Já existe um solicitante cadastrado com a matricula digitada!",
            ];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }

        Applicant::create(["matriculation" => $n_mat, "ramal" => $ramal, "name" => $name, "email" =>$email, "h_d" =>1]);

        $msg = [
            'status' => 1,
            'msg' => "Novo Solicitante cadastrado com sucesso!",
        ];

        return json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    public function newApplicant_bot(Request $request)
    {
        $ramal = $request->ramal;
        $name = $request->nome;
        $email = $request->email;

        $val = Applicant::where("name", $name)->first();

        if ($val)
        {
            $msg = [
                'status' => 0,
                'msg' => "Já existe um solicitante cadastrado com esse nome.",
            ];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }

        Applicant::create(["ramal" => $ramal, "name" => $name, "email" =>$email, "h_d" =>1]);

        $msg = [
            'status' => 1,
            'msg' => "Novo Solicitante cadastrado com sucesso!",
        ];

        return json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    public function editApplicant(Request $request)
    {
        $id = $request->id;
        $mat = $request->mat;
        $ram = $request->ram;
        $name = $request->nome;
        $email = $request->email;

        $st = Applicant::where("id", $id)->update(["matriculation" =>$mat, "ramal" => $ram, "email" => $email, "name" => $name]);

        if($st)
        {
            $response = [
                'status' => 1,
                'msg' => "Solicitante editado com sucesso!"
            ];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }else
        {
            $response = [
                'status' => 2,
                'msg' => "Erro ao editar solicitante!"
            ];
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }

    public function deleteApplicant(Request $request)
    {
        $id = $request->id;
        $motive = $request->motivo;

        $re = Applicant::where("id", $id)->select("h_d")->first();

        if($re->h_d == 2)
        {
            $st = Applicant::where("id", $id)->update(["h_d"=>1, "motive" => $motive]);

            if($st)
            {
                $response = [
                    'status' => 1,
                    'msg' => "Solicitante habilitado com sucesso!"
                ];
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            }else
            {
                $response = [
                    'status' => 2,
                    'msg' => "Erro ao habilitar solicitante!"
                ];
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            }
        }

        if($re->h_d == 1)
        {
            $st = Applicant::where("id", $id)->update(["h_d"=>2, "motive" => $motive]);

            if($st)
            {
                $response = [
                    'status' => 1,
                    'msg' => "Solicitante desabilitado com sucesso!"
                ];
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            }else
            {
                $response = [
                    'status' => 2,
                    'msg' => "Erro ao desabilitar solicitante!"
                ];
                return json_encode($response, JSON_UNESCAPED_UNICODE);
            }
        }
    }
}
