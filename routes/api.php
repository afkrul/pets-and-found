<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PublicPetController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Private API routes for authenticated users
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('pets', PetController::class);
    Route::get('/pets/{pet}/qr-code', [QrCodeController::class, 'getQrCode']); // Get QR code image for a pet
});

// Public endpoint to fetch basic pet info by qr code (no ids or contact details)
Route::get('/public/pets/{qrCode}', [PublicPetController::class, 'show']);
