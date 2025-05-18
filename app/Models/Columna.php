<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Columna extends Model {
    protected $fillable = ['tablero_id', 'nombre', 'posicion'];

    public function tableros() {
        return $this->belongsTo(Tablero::class);
    }
    public function historias() {
        return $this->hasMany(Historia::class);
    }
    public function tablero()
{
    return $this->belongsTo(Tablero::class);
}
}
