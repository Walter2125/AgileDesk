<?php

namespace App\Http\Controllers;
use App\Models\Comentario; 
use App\Models\Historia;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ComentarioController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, $historiaId) 
{ 
    $request->validate([ 
        'contenido' => 'required|string|max:1000', 
    ]); 
 
    Comentario::create([ 
        'historia_id' => $historiaId, 
        'user_id' => auth()->id(), 
        'contenido' => $request->contenido, 
        'parent_id' => $request->parent_id // puede ser null 
    ]); 
 
    return back()->with('success', 'Comentario agregado.'); 
} 
 
public function update(Request $request, Comentario $comentario) 
{ 
    $this->authorize('update', $comentario); // Asegúrate de tener políticas 
 
    $request->validate(['contenido' => 'required|string|max:1000']); 
    $comentario->update(['contenido' => $request->contenido]); 
 
    return back()->with('success', 'Comentario editado.'); 
} 
 
public function destroy(Comentario $comentario) 
{ 
    $this->authorize('delete', $comentario); 
    $comentario->delete(); 
 
    return back()->with('success', 'Comentario eliminado.'); 
} 
 
}
