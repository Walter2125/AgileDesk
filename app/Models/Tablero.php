<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tablero extends Model {
    protected $fillable = ['proyecto_id'];

   // public function proyectos() {
     //   return $this->belongsTo(Project::class);
 //   }

    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }
    public function columnas() {
        return $this->hasMany(Columna::class);
    }
    public function sprints() {
        return $this->hasMany(Sprint::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }


}

