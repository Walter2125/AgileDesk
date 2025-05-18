<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
];

    public function columnas() {
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

}
