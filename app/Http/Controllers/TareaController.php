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
        // Cargar tareas solo para la historia actual
        $tareas = $historia->tareas()->with('user')->get();
        $users = User::all();

        return view('Tareas', compact('tareas', 'users', 'historia'));
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
}