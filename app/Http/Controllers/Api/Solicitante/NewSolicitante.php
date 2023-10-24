<?php

namespace App\Http\Controllers\Api\Solicitante;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Solicitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewSolicitante extends Controller
{
    public function newSolicitante(Request $request)
    {
        $applicant = (new Applicant)->newApplicant($request);

        return $applicant;
    }

    public function newSolicitante_bot(Request $request)
    {
        $applicant = (new Applicant)->newApplicant_bot($request);

        return $applicant;
    }

    public function getSolicitante(){

        $applicant = (new Applicant)->getApplicant();

        return $applicant;
    }

    public function getSolicitanteS()
    {
        $applicant = (new Applicant)->getApplicantS();

        return $applicant;
    }

    public function getSolicitante_condition()
    {

        $applicant = (new Applicant)->getApplicant_condition();

        return $applicant;

    }

    public function getSolicitanteById($id)
    {
        $applicant = (new Applicant)->getApplicantById($id);

        return $applicant;
    }
}
