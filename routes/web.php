<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clinician\AuthController;
use App\Http\Middleware\ClinicianMiddleware;

Route::get('/', function () {
    return view('login');
})->name('clinician_login');

Route::post('clinician/AuthCheck',[AuthController::class,'authCheck'])->name('clinician_checkauth');

Route::prefix('clinician')->middleware(ClinicianMiddleware::class)->group(function () {
    // Route::get('dashbord',[])->name('clinician_dashbord');
    Route::get('/log-out',[AuthController::class,'logout'])->name('clinician_logout'); 
});
