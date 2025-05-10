<?php

// require __DIR__ . '/api/apartado/rutas.php';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\Auth\AuthController;
// Rutas protegidas por autenticación

// protegemos estas rutas con sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('empresa')->group(function () {
        Route::get('all', [EmpresaController::class, 'getAll']); // path: /api/empresa/all
        Route::post('change-status', [EmpresaController::class, 'changeStatus']); // path: /api/empresa/change-status
        Route::post('create', [EmpresaController::class, 'create']); // path: /api/empresa/create
        Route::post('update', [EmpresaController::class, 'update']); // path: /api/empresa/update
        Route::post('delete', [EmpresaController::class, 'delete']); // path: /api/empresa/delete
    });

    Route::prefix('dispositivo')->group(function () {
        Route::get('all', [DispositivoController::class, 'getAll']); // path: /api/dispositivo/all
        Route::post('update', [DispositivoController::class, 'update']); // path: /api/dispositivo/update
    });

    Route::prefix('user')->group(function () {
        Route::get('all', [UserController::class, 'getAll']); // path: /api/user/all
        Route::post('update', [UserController::class, 'update']); // path: /api/user/update
        Route::post('delete', [UserController::class, 'delete']); // path: /api/user/delete
        Route::post('register', [UserController::class, 'register']); // path: /api/user/register
    });
});

Route::prefix('historial')->group(function () {
    Route::get('connect', [HistorialController::class, 'connect']); // path: /api/historial/connect
    Route::post('sync', [HistorialController::class, 'setLogHistorial']); // path: /api/historial/sync
});



Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']); // path: /api/auth/login
    Route::post('token', [AuthController::class, 'validateToken']); // path: /api/auth/token
    Route::post('logout', [AuthController::class, 'logout']); // path: /api/auth/logout
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']); // path: /api/auth/forgot-password
    Route::post('reset-password', [AuthController::class, 'resetPassword']); // path: /api/auth/reset-password
    Route::post('passHash', [AuthController::class, 'passHash']); // path: /api/auth/passHash
});
