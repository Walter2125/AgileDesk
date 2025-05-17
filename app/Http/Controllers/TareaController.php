<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\User;
use App\Models\Historia;
use Illuminate\Http\Request;

class TareaController extends Controller
{
   public function index(Historia $historia)
    {
        $tareas = $historia->tareas()->with('user')->get();
        $users = User::all();

        return view('tareas.create', compact('tareas', 'users', 'historia'));
    }

   public function store(Request $request, Historia $historia)
{
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'historial' => 'nullable|string',
        'actividad' => 'required|in:Configuracion,Desarrollo,Prueba,Diseño',
        'user_id' => 'nullable|exists:users,id',
    ]);

    // Asociar tarea con la historia
    $historia->tareas()->create($validatedData);

    return redirect()->route('tareas.index', $historia->id)->with('success', 'Tarea creada con éxito.');
}

public function edit(Historia $historia, Tarea $tarea)
{
    $users = User::all();
    return view('tareas.edit', compact('historia', 'tarea', 'users'));
}

public function update(Request $request, Historia $historia, Tarea $tarea)
{
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'actividad' => 'required|in:Configuracion,Desarrollo,Prueba,Diseño',
        'user_id' => 'nullable|exists:users,id',
    ]);

    $tarea->update($validatedData);

    return redirect()->route('tareas.index', $historia->id)->with('success', 'Tarea actualizada con éxito.');
}

public function destroy(Historia $historia, Tarea $tarea)
{
    $tarea->delete();

    return redirect()->route('tareas.index', $historia->id)->with('success', 'Tarea eliminada con éxito.');
}

public function lista(Historia $historia)
{
    $tareas = $historia->tareas()->with('user')->get();
    return view('tareas.show', compact('tareas', 'historia'));
}

}