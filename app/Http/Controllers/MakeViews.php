<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Escala;

class MakeViews extends Controller
{
    public function makeViewLogin()
    {

        Auth::user();
        return view('Login.Login_HC');

    }

    public function makeViewDashboard()
    {
        //if(Auth::check() === true)
        //{
            //Auth::user();
            $escala = new Escala();

            $ativa = $escala::whereDate("data_inicio", date("Y-m-d"))
            ->where("active", "=", 1)
            ->get()
            ->toArray();

            if(count($ativa) >= 1)
            {
                return view('Dashboard_Principal.Formularios.Formulario', [
                    "escala_id" => $ativa[0]['id']
                ]);
            }

            return view('Dashboard_Principal.Formularios.Formulario', [
                "escala_id" => null
            ]);

        //}else
        {
            return view('Login.Login_HC');
        }
    }

    public function makeView_Infos()
    {
        if(Auth::check() === true)
        {
            Auth::user();
            return view('Dashboard_Principal.Infos_Admin.infor_admin');
        }else
        {
            return view('Login.Login_HC');
        }
    }
    public function makeView_Avisos()
    {
        if(Auth::check() === true)
        {
            Auth::user();
            return view('Dashboard_Principal.Avisos_Admin.aviso_Admin');
        }else
        {
            return view('Login.Login_HC');
        }
    }

    public function makeViewRelatorios()
    {
        if(Auth::check() === true)
        {
            Auth::user();
            return view('Dashboard_Principal.Relatorios.Relatorio');
        }else
        {
            return view('Login.Login_HC');
        }
    }

    public function makeViewListaSolicitacao()
    {
        if(Auth::check() === true)
        {
            Auth::user();
            return view('Dashboard_Principal.Lista.Lista');
        }else
        {
            return view('Login.Login_HC');
        }

    }

    public function makeViewCad_Del_motorista()
    {
        if(Auth::check() === true)
        {
            Auth::user();
            return view('Dashboard_Principal.Cad_Exc_Motorista.Motorista');
        }else
        {
            return view('Login.Login_HC');
        }
    }
    public function makeViewCad_Del_veiculo()
    {
        if(Auth::check() === true)
        {
            Auth::user();
            return view('Dashboard_Principal.Cad_Exc_Veiculo.Veiculo');
        }else
        {
            return view('Login.Login_HC');
        }
    }
    public function makeViewCad_Del_Solicitante()
    {
        if(Auth::check() === true)
        {
            Auth::user();
            return view('Dashboard_Principal.Cad_Exc_Solicitante.Solicitante');
        }else
        {
            return view('Login.Login_HC');
        }
    }

    public function newScale()
    {
        if(Auth::check() === true)
        {
            Auth::user();
            return view('Dashboard_Principal.Escalas.Escala');
        }else
        {
            return view('Login.Login_HC');
        }
    }

    public function makeView_new_User()
    {
         return view('Dashboard_Principal.Cad_Users_Sistema.Users_Sistema');
    }

    public function makeView_edit_User()
    {
         return view('Dashboard_Principal.Cad_Users_Sistema.Alterar_Users_Sistema');
    }
}
