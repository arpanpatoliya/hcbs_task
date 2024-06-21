<?php

namespace App\Http\Controllers\Clinician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ClinicianLoginRequest;

class AuthController extends Controller
{
    function authCheck(ClinicianLoginRequest $request) {
        $request->validated();
    }
}
