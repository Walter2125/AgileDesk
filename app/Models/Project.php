<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $table = 'nuevo_proyecto';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'descripcion',
        'codigo',
        'fecha_inicio',
        'fecha_fin',
        'user_id',
    ];

    public static function generarCodigo()
    {
    do {
        
        $numero = str_pad(random_int(0, 99), 3, '0', STR_PAD_LEFT);
        $codigo = 'INF' . $numero;

        
        $exists = self::where('codigo', $codigo)->exists();
    } while ($exists);

    return $codigo;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

     public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function historias()
    {
        return $this->hasMany(Historia::class, 'proyecto_id');
    }

    //relacion de tablero
    public function tablero()
    {
        return $this->hasOne(Tablero::class, 'proyecto_id');
    }


    public function sprints()
    {
        return $this->hasManyThrough(
            \App\Models\Sprint::class,
            \App\Models\Tablero::class,
            'proyecto_id',
            'tablero_id',
            'id',
            'id'
        );
    }
    public function tareas() {
    return $this->hasMany(Tarea::class, 'proyecto_id');
}

public function sprint() {
    return $this->hasMany(Sprint::class, 'proyecto_id');
}


}


