<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    

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

    

  public function projects()
{
    return $this->belongsToMany(Project::class);
}
}
