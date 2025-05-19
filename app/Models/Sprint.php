<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model {
    protected $fillable = ['nombre', 'numero_sprint', 'fecha_inicio', 'fecha_fin', 'tablero_id', 'proyecto_id'];


    public function tablero() {
        return $this->belongsTo(Tablero::class);
    }
    public function historias() {
        return $this->hasMany(Historia::class);
    }


}
