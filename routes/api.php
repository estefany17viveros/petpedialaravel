<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VeterinaryController;
use App\Http\Controllers\ProfileController;

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected by Sanctum (works with personal access tokens too)
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
   
Route::middleware('auth:sanctum')->get('/me/trainer', [ProfileController::class, 'trainer']);
Route::middleware('auth:sanctum')->get('/me/veterinary', [ProfileController::class, 'veterinary']);
Route::middleware('auth:sanctum')->get('/me/shelter', [ProfileController::class, 'shelter']);
Route::middleware('auth:sanctum')->get('/me/client', [ProfileController::class, 'client']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products', [ProductController::class, 'index']);
});

// devolver user con profile y role
    Route::get('/user', function (Request $request) {
        return $request->user()->load('profile','role');
    });
});        