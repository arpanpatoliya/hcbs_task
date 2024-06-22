<?php

namespace App\Http\Controllers\Clinician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashbordController extends Controller
{
    function index() {
        return view('dashboard');          
    }
}
