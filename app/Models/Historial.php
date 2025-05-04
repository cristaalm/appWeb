<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'historiales';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa',
        'id_dispositivo',
        'valor',
        'fecha_ingreso',
        'sync',
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
