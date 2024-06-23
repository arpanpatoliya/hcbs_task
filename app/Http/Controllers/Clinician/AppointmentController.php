<?php

namespace App\Http\Controllers\Clinician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    function index() {
        return view('clinician_appointment_details');
    }

    function getAppointments(Request $request) {
        dd($request->all());
    }
}
