<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class HistorialController extends Controller
{

    public function connect(Request $request){
        return $this->apiResponse(200, 'Conectado', null, 200);
    }

    public function setLogHistorial(Request $request)
    {
        try {
            // Si recibes un array de registros
            $data = $request->all();
            $isBatch = is_array($data) && isset($data[0]); // Detecta si es un array de arrays
    
            $result = [];
            if ($isBatch) {
                foreach ($data as $item) {
                    $validated = validator($item, [
                        'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                        'id_dispositivo' => 'required|integer|exists:dispositivos,id_dispositivo',
                        'valor' => 'required|numeric',
                        'fecha_ingreso' => 'required|date',
                    ])->validate();
    
                    $historial = Historial::create([
                        'id_empresa' => $validated['id_empresa'],
                        'id_dispositivo' => $validated['id_dispositivo'],
                        'valor' => $validated['valor'],
                        'fecha_ingreso' => $validated['fecha_ingreso'],
                    ]);
                    $result[] = $historial;
                }
                return $this->apiResponse(201, 'Historiales registrados correctamente', $result, 201);
            } else {
                // Registro individual (retrocompatibilidad)
                $validated = $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'id_dispositivo' => 'required|integer|exists:dispositivos,id_dispositivo',
                    'valor' => 'required|numeric',
                    'fecha_ingreso' => 'required|date',
                ]);
    
                $historial = Historial::create([
                    'id_empresa' => $validated['id_empresa'],
                    'id_dispositivo' => $validated['id_dispositivo'],
                    'valor' => $validated['valor'],
                    'fecha_ingreso' => $validated['fecha_ingreso'],
                ]);
    
                return $this->apiResponse(201, 'Historial registrado correctamente', $historial, 201);
            }
        } catch (ValidationException $e) {
            return $this->apiResponse(422, 'Datos inválidos', $e->errors(), 422);
        } catch (Exception $e) {
            return $this->apiResponse(500, 'Error al guardar el historial: ' . $e->getMessage(), null, 500);
        }
        Log::info('Solicitud de historial', [$request->all()]); // imprime en un archivo de logs la petición
    }
}
