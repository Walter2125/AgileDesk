<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model{   
protected $fillable = [
    'nombre',
    'trabajo_estimado',
    'prioridad',
    'descripcion',
];

    public function columnas() {
        return $this->belongsTo(Columna::class);
    }
    public function sprints() {
        return $this->belongsTo(Sprint::class);
    }

}
