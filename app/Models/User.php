<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    // Agregar campo photo a los fillable
    use HasFactory, Notifiable, SoftDeletes;

    

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',    // nuevo campo para rol
        'is_approved', // nuevo campo para aprobación
        'is_rejected', // Asegúrate de incluir este campo
        'photo',
    ];

    /**
     * Los atributos que deben ocultarse en las serializaciones.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben tener casting a tipos nativos.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_approved'       => 'boolean',
        'is_rejected'       => 'boolean',
        'deleted_at'        => 'datetime',
    ];

    /**
     * Mutator para encriptar automáticamente la contraseña.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Helper para comprobar si el usuario es administrador.
     */
    public function isAdmin(): bool
    {
        return $this->usertype === 'admin';
    }

    /**
     * Relación: un usuario tiene muchas historias (por usuario_id)
     */
    public function historias()
    {
        return $this->hasMany(\App\Models\Historia::class, 'usuario_id');
    }

  public function projects()
{
    return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
 
}
}
