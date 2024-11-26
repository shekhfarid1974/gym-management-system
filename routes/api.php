<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\GymClassController;
use App\Http\Controllers\TrainerClassController;
use App\Http\Controllers\Trainee\BookingController;

// User Authentication Routes
Route::post('login', [AuthController::class, 'login']);
Route::get('me', [AuthController::class, 'me']);

// Admin Routes (Managing Trainers and Classes)
Route::middleware(['auth:api', 'role:Admin'])->group(function () {

    // Trainer Management
    Route::get('/admin/trainers', [TrainerController::class, 'index']);
    Route::post('/admin/trainers', [TrainerController::class, 'store']);
    Route::put('/admin/trainers/{id}', [TrainerController::class, 'update']);
    Route::delete('/admin/trainers/{id}', [TrainerController::class, 'destroy']);

    
    // Class Management
    Route::get('/admin/classes', [GymClassController::class, 'index']);
    Route::post('/admin/classes', [GymClassController::class, 'store']);
});

// Trainer Routes (View Assigned Classes)
Route::middleware(['auth:api', 'role:Trainer'])->group(function () {
    Route::get('/trainer/classes', [TrainerClassController::class, 'index']);
    
});

// Trainee Routes (Profile Management and Class Booking)
Route::middleware(['auth:api', 'role:Trainee'])->group(function () {
    Route::get('/trainee/bookings', [BookingController::class, 'index']);
    Route::post('/trainee/bookings', [BookingController::class, 'store']);
    Route::delete('/trainee/bookings/{id}', [BookingController::class, 'destroy']);
});
