<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{

protected $fillable = ['historia_id', 'user_id', 'contenido', 'parent_id']; 
 
public function historia() 
{ 
    return $this->belongsTo(Historia::class); 
} 
 
public function user() 
{ 
    return $this->belongsTo(User::class, 'user_id');
} 
 
public function respuestas() 
{ 
    return $this->hasMany(Comentario::class, 'parent_id')->with('respuestas'); 
} 
 
public function padre() 
{ 
    return $this->belongsTo(Comentario::class, 'parent_id'); 
}

public function replies()
{
    return $this->hasMany(Comentario::class, 'parent_id')->with('usuario', 'replies');
}
}
