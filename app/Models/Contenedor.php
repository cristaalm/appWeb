<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenedor extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'contenedores';
    protected $primaryKey = 'id_contenedor';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa',
        'id_dispositivo',
        'nombre',
    ];

    // Relaciones
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }
    public function dispositivo()
    {
        return $this->belongsTo(Dispositivo::class, 'id_dispositivo', 'id_dispositivo');
    }
}
