<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Empresa extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'empresa';
    protected $primaryKey = 'id_empresa';
    protected $appends = ['logotipo_url'];
    public $timestamps = false;

    protected $fillable = [
        'razon_social',
        'nombre_comercial',
        'rfc',
        'telefono',
        'logotipo',
        'fecha_ingreso',
        'estado',
    ];
    

    // Relaciones
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_empresa', 'id_empresa');
    }
    public function dispositivoEmpresas()
    {
        return $this->hasMany(DispositivoEmpresa::class, 'id_empresa', 'id_empresa');
    }
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'id_empresa', 'id_empresa');
    }
    public function contenedores()
    {
        return $this->hasMany(Contenedor::class, 'id_empresa', 'id_empresa');
    }
    public function getLogotipoUrlAttribute()
    {
        return $this->logotipo ? Storage::url($this->logotipo) : null;
    }
}
