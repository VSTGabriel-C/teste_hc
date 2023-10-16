<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Solicitacao;
use App\Models\Solicitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Sql;

class NewSolicitations extends Controller
{
    public function newSolicitation(Request $request)
    {
        $solicitation = (new Solicitation)->newSolicitation($request);

        return $solicitation;
    }
}
