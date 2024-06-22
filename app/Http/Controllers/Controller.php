<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    function loginClinician() {
        if (Auth::guard('clinician')->check()) {
            return Auth::guard('clinician')->user();
        }
        return null;
    }
}
