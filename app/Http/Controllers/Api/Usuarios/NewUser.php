<?php

namespace App\Http\Controllers\Api\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class NewUser extends Controller
{
    public function newUser(Request $request)
    {

    $user = (new User)->newUser($request);
    
    return $user;

    }
}
