<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarea extends Model
{
    use HasFactory, SoftDeletes;
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