<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\MutasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Authentication Routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('barangs', BarangController::class);

    Route::apiResource('mutasis', MutasiController::class);

    Route::get('barangs/{id}/history', [MutasiController::class, 'barangHistory']);
    Route::get('users/{id}/history', [MutasiController::class, 'userHistory']);

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
});

