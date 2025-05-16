<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model {
    protected $fillable = ['tablero_id', 'nombre', 'fecha_inicio', 'fecha_fin'];

    public function tablero() {
        return $this->belongsTo(Tablero::class);
    }
    public function historia() {
        return $this->hasMany(Historia::class);
    }


}
