<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPassword;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';
    protected $primaryKey = 'id_usuario'; // Según tu migración personalizada
    public $timestamps = false; // Cambia a true si tienes created_at/updated_at

    protected $fillable = [
        'username',
        'email',
        'name',
        'password',
        'estado',
        'nivel',
        'id_empresa',
    ];

    protected $hidden = [
        'password',
        'remember_token', // Si usas tokens
    ];

    // Relación con empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }

    // Notificación de restablecimiento de contraseña
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token, $this->email));
    }
}
