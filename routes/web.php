<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clinician\{
    AuthController,
    DashbordController,
    AppointmentController,
    SlotController
};
use App\Http\Middleware\ClinicianMiddleware;

Route::get('/clinician', function () {
    return view('login');
})->name('clinician-login');

Route::post('clinician/AuthCheck',[AuthController::class,'authCheck'])->name('clinician-checkauth');
Route::get('clinician/sign-up',function () {
    return view('sign-up');
})->name('clinician-sign_up');
Route::post('/register',[AuthController::class,'signUp'])->name('clinician-register');

Route::prefix('clinician')->middleware(ClinicianMiddleware::class)->group(function () {
    Route::get('dashbord',[DashbordController::class,'index'])->name('clinician-dashbord');
    Route::get('/log-out',[AuthController::class,'logout'])->name('clinician-logout'); 
    Route::prefix('appointment')->group(function () {
        Route::get('/',[AppointmentController::class,'index'])->name('clinician-appointment');
        Route::post('getAppointments',[AppointmentController::class,'getAppointments'])->name('clinician-appointment_ajax');
        Route::post('appointment-status/{id}',[AppointmentController::class,'appointmentStatus'])->name('clinician-appointment_status');
        Route::post('/{appointment}',[AppointmentController::class,'getSingleAppointment'])->name('clinician-SingleAppointment');

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

Route::get('/slots',[SlotController::class,'slots'])->name('slots');
Route::post('/slotAjax',[SlotController::class,'slotAjax'])->name('slot_ajax');
Route::get('/{id}',[SlotController::class,'getSlot'])->name('single_slot');
Route::post('/save-appointment/{slot}',[SlotController::class,'saveAppointment'])->name('appointment-save');
Route::get('/user/appointment',[SlotController::class,'appointment'])->name('user-appointment');
Route::post('/get/appointment',[SlotController::class,'getAppointment'])->name('get-appointment');
