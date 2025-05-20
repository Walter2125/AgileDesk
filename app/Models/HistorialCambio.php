<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialCambio extends Model
{
    protected $table = 'historialcambios';

    protected $fillable = [
        'fecha',
        'usuario',
        'accion',
        'detalles',
        'sprint',
    ];

    public $timestamps = true;
}
