<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Historia extends Model{
    use HasFactory, SoftDeletes;
protected $fillable = [
    'nombre',
    'trabajo_estimado',
    'prioridad',
    'descripcion',
    'columna_id',
    'tablero_id',
    'proyecto_id',
    'usuario_id',
    'sprint_id',
    'numero', 
    'codigo'  
];

    public function columna() {
        return $this->belongsTo(Columna::class);
    }
protected static function boot()
{
    parent::boot();

    static::creating(function ($historia) {
        if ($historia->numero === null && $historia->proyecto_id !== null) {
        
            $maxNumero = self::withTrashed() 
                            ->where('proyecto_id', $historia->proyecto_id)
                            ->max('numero');

            
            $historia->numero = $maxNumero ? $maxNumero + 1 : 1;
        }
    });
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

    // Relación uno a muchos: una historia tiene muchas tareas
    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'historia_id');
    }
   
    public function comentarios()
    {
    return $this->hasMany(Comentario::class);
    }
}
