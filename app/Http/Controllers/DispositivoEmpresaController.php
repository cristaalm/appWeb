<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DispositivoEmpresa;

class DispositivoEmpresaController extends Controller
{
    public function getAll(Request $request) {
        try {
            $id_empresa = $request->input('id_empresa');
            if (!$id_empresa) {
                return $this->apiResponse(false, "Es necesario enviar el id de la empresa", null, "Es necesario enviar el id de la empresa", 400);
            }
            $dispositivosDB = DispositivoEmpresa::where('id_empresa', $id_empresa)->get();
            $dispositivos = [
                [ "id_dispositivo" => 1, "nombre" => 'Sensor de conductividad eléctrica', "descripcion" => 'Mide la conductividad eléctrica de un fluido', "enabled" => false ],
                [ "id_dispositivo" => 2, "nombre" => 'Sensor de pH', "descripcion" => 'Mide la concentración de átomos hidrogenoiones en un fluido', "enabled" => false ],
                [ "id_dispositivo" => 3, "nombre" => 'Sensor de humedad y temperatura', "descripcion" => 'Mide la humedad relativa y la temperatura en un ambiente', "enabled" => false ],
                [ "id_dispositivo" => 4, "nombre" => 'Sensor de temperatura', "descripcion" => 'Mide la temperatura en un ambiente', "enabled" => false ],
                [ "id_dispositivo" => 5, "nombre" => 'Sensor de distancia', "descripcion" => 'Mide la distancia entre dos objetos', "enabled" => false ],
            ];

            foreach ($dispositivosDB as $dispositivoDB) {
                $id_dispositivo = $dispositivoDB->id_dispositivo;

                if ($id_dispositivo == 6) {
                    $dispositivos[2]['enabled'] = true;
                }
                
                $dispositivo = array_search($id_dispositivo, array_column($dispositivos, 'id_dispositivo'));
                
                if ($dispositivo) {
                    $dispositivos[$dispositivo]['enabled'] = true;
                }
            }
            return $this->apiResponse(true, "Dispositivos obtenidos exitosamente", $dispositivos);
        } catch (\Exception $e) {
            return $this->apiResponse(false, "Error al obtener los dispositivos", null, $e->getMessage(), 500);
        }
    }

    public function toggleDevice(Request $request) {
        try{
            $id_dispositivo = $request->input('id_dispositivo');
            $id_empresa = $request->input('id_empresa');
            if (!$id_dispositivo || !$id_empresa) {
                return $this->apiResponse(false, "Es necesario enviar el id del dispositivo y el id de la empresa", null, "Es necesario enviar el id del dispositivo y el id de la empresa", 400);
            }
            // buscamos si la empresa tiene alguna relacion con el id del dispositivo
            $dispositivoDB = DispositivoEmpresa::where('id_dispositivo', $id_dispositivo)->where('id_empresa', $id_empresa)->first();
            
            // si es dispositivo 6 o 3, activamos los 2
            if ($id_dispositivo == 6 || $id_dispositivo == 3) {
                $dispositivoDB = DispositivoEmpresa::where('id_dispositivo', 6)->where('id_empresa', $id_empresa)->first();
                if (!$dispositivoDB) {
                    $dispositivoDB = new DispositivoEmpresa();
                    $dispositivoDB->id_dispositivo = 6;
                    $dispositivoDB->id_empresa = $id_empresa;
                    $dispositivoDB->save();
                }else {
                    $dispositivoDB->delete();
                }
                $dispositivoDB = DispositivoEmpresa::where('id_dispositivo', 3)->where('id_empresa', $id_empresa)->first();
                if (!$dispositivoDB) {
                    $dispositivoDB = new DispositivoEmpresa();
                    $dispositivoDB->id_dispositivo = 3;
                    $dispositivoDB->id_empresa = $id_empresa;
                    $dispositivoDB->save();
                }else {
                    $dispositivoDB->delete();
                }
            }else {
                if (!$dispositivoDB) {
                    $dispositivoDB = new DispositivoEmpresa();
                    $dispositivoDB->id_dispositivo = $id_dispositivo;
                    $dispositivoDB->id_empresa = $id_empresa;
                    $dispositivoDB->save();
                } else {
                    $dispositivoDB->delete();
                }
            }
            
            return $this->apiResponse(true, "Dispositivo configurado exitosamente", $dispositivoDB);
        }catch(\Exception $e){
            return $this->apiResponse(false, "Error al configurar el dispositivo", null, $e->getMessage(), 500);
        }
    }
}
