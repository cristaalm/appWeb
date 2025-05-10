<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;
use \Illuminate\Support\Facades\Password;
use \Illuminate\Support\Facades\Hash;
use \App\Models\User;
use \Carbon\Carbon;
use \Laravel\Sanctum\PersonalAccessToken;
use \Exception;

class UserController extends Controller
{

    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:255|unique:users',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'nivel' => 'required|integer|in:1,2,3',
                'id_empresa' => 'required|integer',
            ]);

            if ( $request->nivel == 1  && $request->id_empresa != 1) {
                return $this->apiResponse(false, 'No tienes permiso para registrar un usuario con nivel 1.', null, null, 400);
            }
            
            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nivel' => $request->nivel,
                'id_empresa' => $request->id_empresa,
            ]);
            return $this->apiResponse(true, 'Usuario registrado correctamente.', ['user' => $user], null, 201);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, 'Datos inválidos para registrar el usuario.', null, $e->errors(), 422);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Ocurrió un error inesperado al registrar el usuario.', null, $e->getMessage(), 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'username' => 'required|string|max:255|unique:users',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'nivel' => 'required|integer|in:1,2,3',
                'id_empresa' => 'required|integer',
            ]);

            $user = User::find($request->id);
            if (!$user) {
                return $this->apiResponse(false, 'Usuario no encontrado.', null, null, 404);
            }

            if ( $request->nivel == 1  && $request->id_empresa != 1) {
                return $this->apiResponse(false, 'No tienes permiso para registrar un usuario con nivel 1.', null, null, 400);
            }

            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->nivel = $request->nivel;
            $user->id_empresa = $request->id_empresa;
            $user->save();
            return $this->apiResponse(true, 'Usuario actualizado correctamente.', ['user' => $user], null, 200);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, 'Datos inválidos para actualizar el usuario.', null, $e->errors(), 422);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Ocurrió un error inesperado al actualizar el usuario.', null, $e->getMessage(), 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);

            $user = User::find($request->id);
            if (!$user) {
                return $this->apiResponse(false, 'Usuario no encontrado.', null, null, 404);
            }
            $user->delete();
            return $this->apiResponse(true, 'Usuario eliminado correctamente.', null, null, 200);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, 'Datos inválidos para eliminar el usuario.', null, $e->errors(), 422);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Ocurrió un error inesperado al eliminar el usuario.', null, $e->getMessage(), 500);
        }
    }

    public function getAll(Request $request)
    {
        try {

            $perPage = $request->input('per_page', 10);
            if (!is_numeric($perPage) || $perPage < 1) {
                $perPage = 10;
            }
            $perPage = min($perPage, 100);
            $query = $request->input('query', '');
            $key = $request->input('key', null);
            $order = $request->input('order', null);
            $usersQuery = User::query();
            if (!empty($query)) {
                $usersQuery->where(function ($q) use ($query) {
                    $q->where('username', 'like', '%' . $query . '%')
                        ->orWhere('name', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                });
            }
            if ($request->has('estado') && $request->input('estado') !== '' && in_array($request->input('estado'), [0, 1])) {
                $usersQuery->where('estado', $request->input('estado'));
            }
            if (!empty($key) && in_array(strtolower($order), ['asc', 'desc'])) {
                $usersQuery->orderBy($key, $order);
            }
            $users = $usersQuery->paginate($perPage);
            return $this->apiResponse(true, 'Usuarios obtenidos correctamente.', ['users' => $users], null, 200);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Ocurrió un error inesperado al obtener los usuarios.', null, $e->getMessage(), 500);
        }
    }
}
