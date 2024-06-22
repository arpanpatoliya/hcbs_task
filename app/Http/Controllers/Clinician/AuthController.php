<?php

namespace App\Http\Controllers\Clinician;

use App\Http\Controllers\Controller;
use App\Models\Clinician;
use Illuminate\Http\Request;
use App\Http\Requests\ClinicianLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function authCheck(ClinicianLoginRequest $request) {
        $validated = $request->validated();
    
        // Directly use the $validated array to extract credentials
        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];
    
        $authCheck = Auth::guard('clinician')->attempt($credentials);

        if ($authCheck) {
            dd(Auth::guard('clinician')->user());
        }

    }

    function logout() {
        if (Auth::guard('')->check()) {
            Auth::guard()->logout();
            Session::flash('message','successfully logged-out');
            return redirect()->route('clinician_login');
        }
        Session::flash('message','Please Login');
        return redirect()->route('clinician_login');
    }
}
