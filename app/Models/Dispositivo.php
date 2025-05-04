<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'dispositivos';
    protected $primaryKey = 'id_dispositivo';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'requiere_contenedor',
        'tiempo_batido',
        'estado',
        'sync',
    ];

    // Relaciones
    public function dispositivoEmpresas()
    {
        return $this->hasMany(DispositivoEmpresa::class, 'id_dispositivo', 'id_dispositivo');
    }
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'id_dispositivo', 'id_dispositivo');
    }
    public function contenedores()
    {
        return $this->hasMany(Contenedor::class, 'id_dispositivo', 'id_dispositivo');
    }
}
