<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Historia extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
    ];  

    // Relación uno a muchos: una historia tiene muchas tareas
    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'historia_id');
    }
}
