<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Formato estándar para respuestas API.
     */
    protected function apiResponse($success, $message, $data = null, $errors = null, $code = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ], $code);
    }
}
