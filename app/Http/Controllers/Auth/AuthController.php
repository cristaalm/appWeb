<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;
use \Illuminate\Support\Facades\Password;
use \Illuminate\Support\Facades\Hash;
use \App\Models\User;
use \Carbon\Carbon;
use \Laravel\Sanctum\PersonalAccessToken;
use \Exception;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{


    public function passHash(Request $request)
    {
        try {
            $request->validate([
                'pass' => 'required',
            ]);
            $hashedPassword = Hash::make($request->pass);
            return $this->apiResponse(true, 'Hash generado correctamente.', ['hashed_password' => $hashedPassword], null, 200);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, 'Datos inválidos para generar hash.', null, $e->errors(), 422);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Ocurrió un error inesperado al generar el hash.', null, $e->getMessage(), 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'user' => 'required',
                'pass' => 'required',
                'remember' => 'boolean',
            ]);
            $user = User::where('username', $request->user)->first();
            if (!$user) {
                return $this->apiResponse(false, 'Usuario o contraseña incorrectos.', null, null, 401);
            }
            // Si tienes algún campo de estado (activo/inactivo) puedes validarlo aquí:
            if (isset($user->estado) && $user->estado != 1) {
                return $this->apiResponse(false, 'El usuario no está activo.', null, null, 403);
            }
            if (!Hash::check($request->pass, $user->password)) {
                return $this->apiResponse(false, 'Usuario o contraseña incorrectos.', null, null, 401);
            }
            $expiresAt = $request->remember
                ? Carbon::now()->addYear()
                : (config('sanctum.expiration') ? Carbon::now()->addMinutes(config('sanctum.expiration')) : null);
            $tokenResult = $user->createToken('auth-token', [], $expiresAt);
            return $this->apiResponse(true, 'Inicio de sesión exitoso.', [
                'access_token' => $tokenResult->plainTextToken,
                'user' => $user,
                'nivel' => $user->nivel,
                'expires_at' => $expiresAt,
            ], null, 200);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, 'Datos de acceso inválidos.', null, $e->errors(), 422);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Ocurrió un error inesperado al iniciar sesión.', null, $e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return $this->apiResponse(false, 'Token de autenticación no proporcionado.', null, null, 401);
        }
        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken) {
            return $this->apiResponse(false, 'Token inválido o no encontrado.', null, null, 401);
        }
        $accessToken->delete();
        return $this->apiResponse(true, 'Sesión cerrada correctamente.', null, null, 200);
    }

    public function validateToken(Request $request)
    {
        try {
            $token = $request->bearerToken();
            if (!$token) {
                return $this->apiResponse(false, 'Token no proporcionado', null, null, 401);
            }
            $accessToken = PersonalAccessToken::findToken($token);
            if (!$accessToken) {
                return $this->apiResponse(false, 'Token inválido', null, null, 401);
            }
            if ($accessToken->expires_at && $accessToken->expires_at->isPast()) {
                $accessToken->delete();
                return $this->apiResponse(false, 'Token expirado', null, null, 401);
            }
            // Si tienes permisos o roles, puedes agregarlos aquí como en el ejemplo original.
            return $this->apiResponse(true, 'Token válido', [
                'user' => $accessToken->tokenable,
                'nivel' => $accessToken->tokenable->nivel,
                'expires_at' => $accessToken->expires_at,
            ], null, 200);
        } catch (\Exception $e) {
            return $this->apiResponse(false, 'Error al validar el token', null, $e->getMessage(), 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->apiResponse(false, 'El correo electrónico no está registrado en el sistema.', null, null, 404);
            }
            $status = Password::sendResetLink(
                $request->only('email')
            );
            if ($status === Password::RESET_LINK_SENT) {
                return $this->apiResponse(true, 'Enlace de restablecimiento de contraseña enviado correctamente.', null, null, 200);
            }
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, 'Correo electrónico inválido o no registrado.', null, $e->errors(), 422);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Ocurrió un error inesperado al enviar el enlace de restablecimiento.', null, $e->getMessage(), 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
                'token' => 'required',
            ]);
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->password = Hash::make($password);
                    $user->save();
                }
            );
            if ($status === Password::PASSWORD_RESET) {
                return $this->apiResponse(true, 'Contraseña restablecida correctamente.', null, null, 200);
            }
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, 'Datos inválidos para restablecer la contraseña.', null, $e->errors(), 422);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Ocurrió un error inesperado al restablecer la contraseña.', null, $e->getMessage(), 500);
        }
    }
}
