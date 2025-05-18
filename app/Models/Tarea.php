<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarea extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'historial',
        'actividad',
        'user_id',
        'historia_id',
    ];

    // Relación muchos a uno: una tarea pertenece a una historia
    public function historia(): BelongsTo
    {
        return $this->belongsTo(Historia::class, 'historia_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}