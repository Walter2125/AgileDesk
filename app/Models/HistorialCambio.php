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
    protected $casts = [
    'fecha' => 'datetime',
];

// Método para registrar cambios fácilmente
public static function registrar($accion, $detalles, $proyecto_id, $sprint_id = null)
{
    return self::create([
        'fecha' => now(),
        'usuario' => auth()->user()->name,
        'accion' => $accion,
        'detalles' => $detalles,
        'sprint' => $sprint_id,
        'proyecto_id' => $proyecto_id
    ]);
}
}
