<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Private API routes for authenticated users
Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::resource('pets', PetController::class);
});
