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
     'columna_id',
    'tablero_id',
    'proyecto_id',
    'usuario_id',
    'sprint_id'
];

    public function columna() {
        return $this->belongsTo(Columna::class);
    }
    
    public function sprints() {
        return $this->belongsTo(Sprint::class);
    }
    //relacion necesaria con proyecto
    public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }



    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación uno a muchos: una historia tiene muchas tareas
    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'historia_id');
    }


}
