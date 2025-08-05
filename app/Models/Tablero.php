<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tablero extends Model {
    use HasFactory;
    protected $fillable = ['proyecto_id'];

   // public function proyectos() {
    public function columnas() {
        return $this->hasMany(Columna::class)->orderBy('posicion', 'asc');
    }
    public function sprints() {
        return $this->hasMany(Sprint::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'proyecto_id');
    }
    public function proyecto()
{
    return $this->belongsTo(Project::class, 'proyecto_id');
}


}
