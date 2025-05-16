<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{   
protected $fillable = [
    'nombre',
    'trabajo_estimado',
    'prioridad',
    'descripcion',
];
}
