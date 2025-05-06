<?php

// require __DIR__ . '/api/apartado/rutas.php';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\UserController;
// Rutas protegidas por autenticación

Route::prefix('historial')->group(function () {
    Route::get('connect', [HistorialController::class, 'connect']); // path: /api/documents
    Route::post('sync', [HistorialController::class, 'setLogHistorial']); // path: /api/documents
});

Route::prefix('auth')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('token', [UserController::class, 'validateToken']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('forgot-password', [UserController::class, 'forgotPassword']);
    Route::post('reset-password', [UserController::class, 'resetPassword']);
    Route::post('passHash', [UserController::class, 'passHash']);
});
