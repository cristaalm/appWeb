<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispositivoEmpresa extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'dispositivo_empresa';
    protected $primaryKey = 'id_dispositivo_empresa';
    public $timestamps = false;

    protected $fillable = [
        'id_empresa',
        'id_dispositivo',
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
