<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class HistorialController extends Controller
{
    /**
     * Obtener historial con paginación, filtrado por fecha y tipo de dispositivo (nombre).
     */
    public function getAll(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            if (!is_numeric($perPage) || $perPage < 1) {
                $perPage = 10;
            }
            $perPage = min($perPage, 100);

            $fechaInicio = $request->input('fecha_inicio');
            $fechaFin = $request->input('fecha_fin');
            $tipoDispositivo = $request->input('tipo_dispositivo'); // id o nombre del dispositivo
            $idEmpresa = $request->input('id_empresa');

            $historialQuery = Historial::query();

            
            // Join con dispositivos para poder filtrar por nombre
            $historialQuery->join('dispositivos', 'historiales.id_dispositivo', '=', 'dispositivos.id_dispositivo')
            ->select('historiales.*', 'dispositivos.nombre as nombre_dispositivo');
            $historialQuery->where('historiales.id_empresa', '=', $idEmpresa);
            
            if (!empty($fechaInicio) && $fechaInicio !== 'undefined' && $fechaInicio !== 'null') {
                $fechaInicio = date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $fechaInicio)));
                $historialQuery->where('fecha_ingreso', '>=', $fechaInicio);
            }
            if (!empty($fechaFin) && $fechaFin !== 'undefined' && $fechaFin !== 'null') {
                $fechaFin = date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $fechaFin)));
                $historialQuery->where('fecha_ingreso', '<=', $fechaFin);
            }

            if (!empty($tipoDispositivo)) {
                if (is_numeric($tipoDispositivo)) {
                    $historialQuery->where('dispositivos.id_dispositivo', '=', $tipoDispositivo);
                } else {
                    $historialQuery->where('dispositivos.nombre', 'like', "%$tipoDispositivo%");
                }
            }

            $historialQuery->orderBy('fecha_ingreso', 'desc');

            $historiales = $historialQuery->paginate($perPage);

            return $this->apiResponse(200, 'Historiales obtenidos correctamente.', $historiales, null, 200);
        } catch (\Exception $e) {
            return $this->apiResponse(500, 'Ocurrió un error al obtener los historiales.', null, $e->getMessage(), 500);
        }
    }

    // funcion que retorna todos los datos del ultimo mes (id del dispositivo, valor y fecha del registro)
    public function getLastMonthData(Request $request)
    {
        try {
            $idDispositivo = $request->input('id_dispositivo');
            $idEmpresa = $request->input('id_empresa');
    
            if (empty($idDispositivo)) {
                return $this->apiResponse(400, 'No se proporcionó el id del dispositivo.', null, 'No se proporcionó el id del dispositivo.', 400);
            }
    
            // Obtener los promedios diarios
            $historiales = DB::table('historiales')
                ->selectRaw('id_dispositivo, DATE(fecha_ingreso) as fecha, AVG(valor) as valor')
                ->where('id_dispositivo', $idDispositivo)
                ->where('id_empresa', $idEmpresa)
                ->where('fecha_ingreso', '>=', now()->subMonth())
                ->groupByRaw('id_dispositivo, DATE(fecha_ingreso)')
                ->orderBy('fecha', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id_dispositivo' => $item->id_dispositivo,
                        'valor' => round($item->valor, 2),
                        'fecha_ingreso' => $item->fecha . ' 00:00:00',
                    ];
                });
    
            // Si hay al menos 2 días con registros, calculamos profitloss y current
            $count = $historiales->count();
            $current = null;
            $profitloss = null;
    
            if ($count >= 2) {
                $lastDay = $historiales[$count - 1]['valor'];
                $prevDay = $historiales[$count - 2]['valor'];
    
                $current = $lastDay;
                $profitloss = round($lastDay - $prevDay, 2);
            } elseif ($count === 1) {
                $current = $historiales[0]['valor'];
                $profitloss = null; // no hay día anterior
            }
    
            // Retornar todo en una sola respuesta
            return $this->apiResponse(200, 'Promedio diario obtenido correctamente.', [
                'data' => $historiales,
                'current' => $current,
                'profitloss' => $profitloss,
            ], null, 200);
    
        } catch (\Exception $e) {
            return $this->apiResponse(500, 'Ocurrió un error al obtener los datos.', null, $e->getMessage(), 500);
        }
    }
    

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
