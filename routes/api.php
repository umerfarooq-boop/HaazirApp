<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsImageController;
use App\Http\Controllers\PlumberAppointmentController;
use App\Http\Controllers\ElectricianAppointmentController;




// 🔵 Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// 🔵 Profile routes (protected by JWT)
// Route::middleware(['jwt.auth'])->group(function () {
//     Route::resource('/profile', ProfileController::class, 'store');
//     Route::resource('/plumber_appointment', PlumberAppointmentController::class);
//     Route::get('/check-profile/{userId}', [ProfileController::class, 'checkProfile']);
// });

Route::middleware(['jwt.auth'])->group(function () {
    // Resource route for ProfileController with only 'store' action
    Route::resource('/profile', ProfileController::class);
    
    // Full resource route for PlumberAppointmentController
    Route::resource('/plumber_appointment', PlumberAppointmentController::class);

    Route::post('/Accpet_P_Appointment/{id}',[PlumberAppointmentController::class,'Accpet_P_Appointment']);
    Route::post('/Accpet_E_Appointment/{id}',[ElectricianAppointmentController::class,'Accpet_E_Appointment']);
    Route::resource('/electrician_appointment', ElectricianAppointmentController::class);
    // Route for checking profile by user ID
    Route::get('/check-profile/{userId}', [ProfileController::class, 'checkProfile']);
});



