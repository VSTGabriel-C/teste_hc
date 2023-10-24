<?php

namespace App\Http\Controllers\Api\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class EditarUser extends Controller
{
  public function allUserss()
    {
        $user = (new User)->allUserss();

        return $user;

    }

    public function allUserssL()
    {

        $user = (new User)->allUserssL();

        return $user;

    }

    public function get_Users_By_Id($id)
    {
        $user = (new User)->get_Users_By_Id($id);

        return $user;

    }

    public function edit_User_By_Id(Request $request)
    {
        $edit = (new User)->edit_User_By_Id($request);
    }
}
