<?php

namespace App\Http\Controllers\Api\Solicitante;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditSolicitante extends Controller
{
    public function editSolicitante(Request $request)
    {
        $applicant = (new Applicant)->editApplicant($request);

        return $applicant;
    }
}
