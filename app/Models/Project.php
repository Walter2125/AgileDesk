<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'nuevo_proyecto';
    protected $primaryKey = 'id';

    // Añade esta propiedad para permitir asignación masiva
    protected $fillable = [
        'name',
        'fecha_inicio',
        'fecha_fin',
        'user_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    public function tablero()
    {
        return $this->hasOne(Tablero::class, 'proyecto_id');
    }
    
    //relacion nesesaria con historias
    public function historias()
{
    return $this->hasMany(Historia::class, 'proyecto_id');
}

}
