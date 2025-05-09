<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dispositivo;

class DispositivoController extends Controller
{
    public function getAll(Request $request) {
        try {
            $dispositivos = Dispositivo::all();
            return $this->apiResponse(true, "Dispositivos obtenidos exitosamente", $dispositivos);
        } catch (\Exception $e) {
            return $this->apiResponse(false, "Error al obtener los dispositivos", null, $e->getMessage(), 500);
        }
    }
    
    public function update(Request $request) {
        try {
            // validamos la request
            $request->validate([
                'id_dispositivo' => 'required|exists:dispositivos,id_dispositivo',
                'tiempo_batido' => 'nullable|numeric',
                'valor_minimo' => 'nullable|numeric',
                'valor_maximo' => 'nullable|numeric',
            ]);

            $dispositivo = Dispositivo::find($request->id_dispositivo);
            if (!$dispositivo) {
                return $this->apiResponse(false, "Dispositivo no encontrado", null, "Dispositivo no encontrado", 404);
            }

            // asignamos nuevo valor si no es null
            $dispositivo->tiempo_batido = $request->tiempo_batido ?? $dispositivo->tiempo_batido;
            $dispositivo->valor_minimo = $request->valor_minimo ?? $dispositivo->valor_minimo;
            $dispositivo->valor_maximo = $request->valor_maximo ?? $dispositivo->valor_maximo;
            $dispositivo->save();
            
            return $this->apiResponse(true, "Dispositivo actualizado exitosamente", $dispositivo);
        } catch (\Exception $e) {
            return $this->apiResponse(false, "Error al actualizar el dispositivo", null, $e->getMessage(), 500);
        }
    }
}
