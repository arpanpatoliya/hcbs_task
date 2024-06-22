<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clinician\{
    AuthController,
    DashbordController
};
use App\Http\Middleware\ClinicianMiddleware;

Route::get('/', function () {
    return view('login');
})->name('clinician-login');

Route::post('clinician/AuthCheck',[AuthController::class,'authCheck'])->name('clinician-checkauth');

Route::prefix('clinician')->middleware(ClinicianMiddleware::class)->group(function () {
    Route::get('dashbord',[DashbordController::class,'index'])->name('clinician-dashbord');
    Route::get('/log-out',[AuthController::class,'logout'])->name('clinician-logout'); 
});
