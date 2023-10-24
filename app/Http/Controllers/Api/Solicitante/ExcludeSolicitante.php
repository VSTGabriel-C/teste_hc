<?php

namespace App\Http\Controllers\Api\Solicitante;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;

class ExcludeSolicitante extends Controller
{
    public function excludeSolicitante(Request $request)
    {
        $applicant = (new Applicant)->deleteApplicant($request);

        return $applicant;
    }
}
