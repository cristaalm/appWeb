<?php

// require __DIR__ . '/api/apartado/rutas.php';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistorialController;
// Rutas protegidas por autenticación

Route::prefix('historial')->group(function () {
    Route::get('connect', [HistorialController::class, 'connect']); // path: /api/documents
    Route::post('sync', [HistorialController::class, 'setLogHistorial']); // path: /api/documents
});
