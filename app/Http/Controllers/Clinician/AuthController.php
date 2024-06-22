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
    
        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];
    
        try {
            $authCheck = Auth::guard('clinician')->attempt($credentials);

            if ($authCheck) {
                Session::flash('message','successfully logged in');
                return redirect()->route('clinician-dashbord');
            };
            Session::flash('message','invalid credentials');
            return redirect()->back();

        } catch (\Exception $ex) {
            Session::flash('message',$ex->getMessage());
            return redirect()->back();
        }

    }

    function logout() {
        if (Auth::guard('clinician')->check()) {
            Auth::guard('clinician')->logout();
            Session::flash('message','successfully logged-out');
            return redirect()->route('clinician-login');
        }
        Session::flash('message','Please Login');
        return redirect()->route('clinician-login');
    }
}
