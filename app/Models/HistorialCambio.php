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
        'proyecto_id',
    ];

    public $timestamps = true;

    public function proyecto()
{
    return $this->belongsTo(Project::class, 'proyecto_id');
}
}
