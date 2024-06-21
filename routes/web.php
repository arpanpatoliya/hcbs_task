<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clinician\AuthController;

Route::get('/clinician/login', function () {
    return view('login');
});

Route::post('clinician/AuthCheck',[AuthController::class,''])->name('clinician_checkauth');
