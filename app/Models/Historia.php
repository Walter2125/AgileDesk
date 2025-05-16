<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

// Relación uno a muchos: una historia tiene muchas tareas
public function tareas(): HasMany
{
    return $this->hasMany(Tarea::class, 'historia_id');
}

}
