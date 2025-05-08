<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function getAll(Request $request) {
        $empresas = Empresa::all()->map(function ($empresa) {
            return [
                'id_empresa' => $empresa->id_empresa,
                'razon_social' => $empresa->razon_social,
                'nombre_comercial' => $empresa->nombre_comercial,
                'rfc' => $empresa->rfc,
                'telefono' => $empresa->telefono,
                'estado' => $empresa->estado,
                'fecha_ingreso' => $empresa->fecha_ingreso,
                'logotipo' => $empresa->logotipo_url, // URL completa
            ];
        });
    
        return $this->apiResponse(true, 'Empresas obtenidas exitosamente', $empresas);
    }

    public function changeStatus(Request $request){
        $empresa = Empresa::find($request->id_empresa);
        $empresa->estado = $request->estado;
        $empresa->save();

        $empresa->logotipo = $empresa->logotipo ? Storage::url($empresa->logotipo) : null;
        return $this->apiResponse(true, 'Estado cambiado exitosamente', $empresa);
    }

    public function create(Request $request) {
        $request->merge([
            'estado' => filter_var($request->estado, FILTER_VALIDATE_BOOLEAN),
        ]);
        
        $request->validate([
            'razon_social' => 'required|string|max:255',
            'nombre_comercial' => 'required|string|max:255',
            'rfc' => 'required|string|max:13',
            'telefono' => 'required|string|max:20',
            'estado' => 'required|boolean',
        ]);
    
        $empresa = new Empresa();
        $empresa->razon_social = $request->razon_social;
        $empresa->nombre_comercial = $request->nombre_comercial;
        $empresa->rfc = $request->rfc;
        $empresa->telefono = $request->telefono;
        $empresa->estado = $request->estado;
    
        // Guardar logotipo
        if ($request->hasFile('logotipo')) {
            $request->validate([
                'logotipo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $file = $request->file('logotipo');
            $path = $file->store('logotipos', 'public');
            $empresa->logotipo = $path; // Guarda solo la ruta relativa
        }
    
        $empresa->save();
    
        $empresa->logotipo = $empresa->logotipo ? Storage::url($empresa->logotipo) : null;
    
        return $this->apiResponse(true, 'Empresa creada exitosamente', $empresa);
    }

    public function update(Request $request) {
        $request->merge([
            'estado' => filter_var($request->estado, FILTER_VALIDATE_BOOLEAN),
        ]);
        
        $request->validate([
            'razon_social' => 'required|string|max:255',
            'nombre_comercial' => 'required|string|max:255',
            'rfc' => 'required|string|max:13',
            'telefono' => 'required|string|max:20',
            'estado' => 'required|boolean',
        ]);

        $empresa = Empresa::find($request->id_empresa);
        
        $empresa->razon_social = $request->razon_social;
        $empresa->nombre_comercial = $request->nombre_comercial;
        $empresa->rfc = $request->rfc;
        $empresa->telefono = $request->telefono;
        $empresa->estado = $request->estado;
        
        if ($request->hasFile('logotipo')) {
            $file = $request->file('logotipo');
            $path = $file->store('logotipos', 'public');
            $empresa->logotipo = $path;
        } else if ($request->logotipo == "null") {
            Storage::delete($empresa->logotipo);
            $empresa->logotipo = null;
        }
        
        $empresa->save();
        
        $empresa->logotipo = $empresa->logotipo ? Storage::url($empresa->logotipo) : null;
        return $this->apiResponse(true, 'Empresa actualizada exitosamente', $empresa);
    }

    public function delete(Request $request)
    {
        try {
            $empresa = Empresa::find($request->id_empresa);
    
            if (!$empresa) {
                return $this->apiResponse(false, 'Empresa no encontrada');
            }
    
            $logoPath = $empresa->logotipo;
            $empresa->delete();
    
            if ($logoPath) {
                Storage::delete($logoPath);
            }
    
            return $this->apiResponse(true, 'Empresa eliminada exitosamente', $empresa);
        } catch (\Illuminate\Database\QueryException $e) {
            // Código de error de clave foránea en PostgreSQL: 23503
            if ($e->getCode() === '23503') {
                return $this->apiResponse(false, 'No se puede eliminar la empresa porque está vinculada a otros registros.', null);
            }
    
            return $this->apiResponse(false, 'Error de base de datos al eliminar la empresa', $e->getMessage());
        } catch (\Exception $e) {
            return $this->apiResponse(false, 'Error inesperado al eliminar la empresa', $e->getMessage());
        }
    }
    
}
