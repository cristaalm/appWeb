<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Formato estándar para respuestas API.
     */
    protected function apiResponse($status, $message, $data = null, $httpCode = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $httpCode);
    }
}
