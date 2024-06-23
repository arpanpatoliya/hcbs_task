<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clinician\{
    AuthController,
    DashbordController,
    AppointmentController,
    SlotController
};
use App\Http\Middleware\ClinicianMiddleware;

Route::get('/', function () {
    return view('login');
})->name('clinician-login');

Route::post('clinician/AuthCheck',[AuthController::class,'authCheck'])->name('clinician-checkauth');

Route::prefix('clinician')->middleware(ClinicianMiddleware::class)->group(function () {
    Route::get('dashbord',[DashbordController::class,'index'])->name('clinician-dashbord');
    Route::get('/log-out',[AuthController::class,'logout'])->name('clinician-logout'); 
    Route::prefix('appointment')->group(function () {
        Route::get('/',[AppointmentController::class,'index'])->name('clinician-appointment');
        Route::post('getAppointments',[AppointmentController::class,'getAppointments'])->name('clinician-appointment_ajax');
    });
    Route::prefix('slot')->group(function () {
        Route::get('/',[SlotController::class,'index'])->name('clinician-slot');
        Route::get('/{id}',[SlotController::class,'getSlot'])->name('clinician-single_slot');
        Route::post('getSlots',[SlotController::class,'getSlots'])->name('clinician-slot_ajax');
        Route::post('slotStore',[SlotController::class,'store'])->name('clinician-slot_store');
        Route::post('slotUpdate/{id}',[SlotController::class,'update'])->name('clinician-slot_update');
        Route::get('slotdelete/{id}',[SlotController::class,'delete'])->name('clinician-slot_delete');

    }); 
});
