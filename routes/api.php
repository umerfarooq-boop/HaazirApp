<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlumberAppointmentController;




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
    Route::post('/profile', [ProfileController::class, 'store']);
    
    // Full resource route for PlumberAppointmentController
    Route::resource('/plumber_appointment', PlumberAppointmentController::class);

    // Route for checking profile by user ID
    Route::get('/check-profile/{userId}', [ProfileController::class, 'checkProfile']);
});

