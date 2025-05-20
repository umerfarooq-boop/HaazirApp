<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;




// 🔵 Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// 🔵 Profile routes (protected by JWT)
Route::middleware(['jwt.auth'])->group(function () {
    // Main profile resource routes: index, show, store, update, destroy
    Route::resource('/profile', ProfileController::class, 'store');

    // 🔥 Special route to check if profile exists
    Route::get('/check-profile/{userId}', [ProfileController::class, 'checkProfile']);
});
