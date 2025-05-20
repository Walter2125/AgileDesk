<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'nuevo_proyecto';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'fecha_inicio', 'fecha_fin', 'user_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }
    
     public function creator()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
    
    //relacion nesesaria con historias
    public function historias()
    {
        return $this->hasMany(Historia::class, 'proyecto_id');
    }
    
    //relacion de tablero
    public function tablero()
    {
        return $this->hasOne(Tablero::class, 'proyecto_id');
    }
}

