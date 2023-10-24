<?php

namespace App\Models;

use App\Traits\HttpResponses;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HttpResponses;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'date', 'name', 'camFoto', 'admin', 'active', "camFoto"];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }

    public function login_model($request)
    {
        $headers = [
            'email' => $request->header()['php-auth-user'][0],
            'password' => $request->header()['php-auth-pw'][0],
        ];

        $user = User::where('email', $headers['email'])->first();
        $token = $user->createToken('API Token of' . $user->email)->plainTextToken;

        return $this->succes([
            'user' => $user,
            'token' => $token
        ], 'login success');
    }

    public function update_model(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        if (!$user) {
            return $this->error('', 'Credential do not match', 401);
        }

        $user->update($request->all());

        return $this->succes([
            'user' => $user
        ], 'User updated successfully');
    }

    public function delete_model()
    {
        $user = User::where('id', Auth::user()->id)->first();
        if (!$user) {
            return $this->error('', 'Credential do not match', 401);
        }

        $user->delete();

        return $this->succes('', 'User deleted successfully');
    }

    public function newUser(Request $request)
    {

        $email = $request->u_email;
        $nome = $request->u_nome;
        $senha = $request->u_senha;
        $confirm = $request->s_confirm;
        $tipo = $request->tipo_user;
        $newTipo = 0;
        $data_atual = date("Y-m-d");
        $newPic = $this->storeIm($request);

        $msg = array();

        $if = User::where("email", $email)->first();

        if ($if) {
            $msg = array(
                'status' => 1,
                'msg' => "E-mail informado já está cadastrado"
            );
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        } else {
            if ($senha == $confirm) {
                if ($tipo == "Admin") {
                    $newTipo = 1;
                } else if ($tipo == "Normal") {
                    $newTipo = 2;
                }

                User::create([
                    "email" => $email,
                    'password' => Hash::make($request->password),
                    "date" => $data_atual,
                    "name" => $nome,
                    "admin" => $newTipo,
                    "active" => 1,
                    "camFoto" => $newPic
                ]);

                $msg = array(
                    'status' => 0,
                    'msg' => "Usuário cadastrado com sucesso!"
                );

                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            } else {
                $msg = array(
                    'status' => 1,
                    'msg' => "Senhas não conferem!"
                );
                return redirect()->route('hc_add_new_admin', $msg);
            }
        }
    }

    public function storeIm($request)
    {
        $nameFile = '';

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = uniqid(date('dmY'));

            $extension = $request->all()['image']->extension();

            $path = "public/images/fotos";

            if ($extension != 'jpeg' && $extension != 'png' && $extension != 'svg' && $extension != "jpg") {
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload, formato do arquivo está errado.')
                    ->withInput();
            }
            $nameFile = "{$name}.{$extension}";

            $upload = $request->file('image')->storeAS($path, $nameFile);

            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload')
                    ->withInput();
        }
        return $nameFile;
    }

    public function allUserss()
    {
        $res = User::get();
        return json_encode($res);
    }

    public function allUserssL()
    {
        $res = User::orderBy("id", "asc")->get();
        $arr = ['data' => $res];
        $sm = $arr;
        return json_encode($sm, JSON_UNESCAPED_UNICODE);
    }

    public function get_Users_By_Id($id)
    {
        $res = User::where("id", $id)->select("name", "email")->first();

        return json_encode($res);
    }

    public function hbl_desb(Request $request)
    {
        $ativo = $request->ativo;
        $id = $request->id;

        if ($ativo == 1) {
            $hbl_des = User::where("id", $id)->update(["active" => 0]);

            if ($hbl_des) {
                $msg = [
                    "status" => 1,
                    "msg" => "Usuario desabilitado com sucesso!"
                ];
                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            } else {
                $msg = [
                    "status" => 0,
                    "msg" => "Erro ao desabilitar usuario!"
                ];
                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            }
        } else if ($ativo == 0) {
            $hbl_des = User::where("id", $id)->update(["active" => 1]);

            if ($hbl_des) {
                $msg = [
                    "status" => 1,
                    "msg" => "Usuario habilitado com sucesso!"
                ];
                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            } else {
                $msg = [
                    "status" => 0,
                    "msg" => "Erro ao habilitar usuario!"
                ];
                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function edit_User_By_Id(Request $request)
    {
        $name = $request->nome;
        $e_mail = $request->email;
        $senha = $request->password;
        $senha_C = $request->password_C;
        $ids = $request->idE;
        $picEdit = $this->storeImE($request, $ids);

        if ($picEdit != '') {
            $result = User::where("id", $ids)->update(["camFoto" => $picEdit]);

            if ($result) {
                $msg = [
                    "status" => 1,
                    "msg" => "Foto Editada com sucesso. Por favor relogue no sistema!"
                ];

                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            } else {
                $msg = [
                    "status" => 0,
                    "msg" => "Não foi possivel editar a foto."
                ];
                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            }
        }

        if (is_null($senha) && is_null($senha_C)) {
            $result = User::where("id", $ids)->update(["name" => $name, "email" => $e_mail]);

            if ($result) {
                $msg = [
                    "status" => 1,
                    "msg" => "Usuario editado com sucesso!"
                ];
                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            } else {
                $msg = [
                    "status" => 0,
                    "msg" => "Não foi possivel editar o usuario pois nada foi alterado."
                ];
                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            }
        }

        if ($senha == $senha_C) {
            $result = User::where("id", $ids)->update(["name" => $name, "email" => $e_mail, "password" => Hash::make($senha)]);
            if ($result) {
                $msg = [
                    "status" => 1,
                    "msg" => "Usuario editado com sucesso!"
                ];

                return json_encode($msg, JSON_UNESCAPED_UNICODE);;
            } else {
                $msg = [
                    "status" => 0,
                    "msg" => "Não foi possivel editar o usuario (Senhas não conferem) !"
                ];

                return json_encode($msg, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $msg = [
                "status" => 0,
                "msg" => "Não foi possivel alterar o usuario (Senhas não conferem) !"
            ];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
    }

    public function storeImE($request, $id)
    {

        $res = DB::select(
            "SELECT
        u.camFoto
        FROM users u
        WHERE u.id = ?",
            [
                $id
            ]
        );

        $nameFile = '';

        if ($request->hasFile('imageE') && $request->file('imageE')->isValid()) {
            if ($res[0]->camFoto != '') {
                unlink(public_path('/storage/images/fotos/' . $res[0]->camFoto));
            }

            $name = uniqid(date('dmY'));

            $extension = $request->all()['imageE']->extension();

            $path = "public/images/fotos";

            if ($extension != 'jpeg' && $extension != 'png' && $extension != 'svg' && $extension != "jpg") {
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload, formato do arquivo está errado.')
                    ->withInput();
            }
            $nameFile = "{$name}.{$extension}";

            $upload = $request->file('imageE')->storeAS($path, $nameFile);
            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload')
                    ->withInput();
        }

        return $nameFile;
    }
}
