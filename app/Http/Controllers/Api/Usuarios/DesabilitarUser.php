<?php

namespace App\Http\Controllers\Api\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesabilitarUser extends Controller
{
    public function hbl_desb(Request $request)
    {
        $hbl_desb = (new User)->hbl_desb($request);

        return $hbl_desb;
    }
}
