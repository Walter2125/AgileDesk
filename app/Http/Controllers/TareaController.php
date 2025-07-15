<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\User;
use App\Models\Historia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TareaController extends Controller
{

    private function cargarTablero(Historia $historia)
    {
        $historia->load('columna.tablero.project');
        $tablero = $historia->columna?->tablero;
        View::share('tablero', $tablero);
        return $tablero;
    }
  public function index(Historia $historia)
    {
        $tablero = $this->cargarTablero($historia);
        $tareas = $historia->tareas()->with('user')->get();
        $users = User::all();

        return view('tareas.create', compact('tareas', 'users', 'historia'));
    }

    public function store(Request $request, Historia $historia)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string', // ← ahora obligatorio
            'actividad' => 'required|in:Configuracion,Desarrollo,Prueba,Diseño,OtroTipo',

             ], [
        'nombre.required' => 'El nombre de la tarea es obligatorio.',
        'nombre.string' => 'El nombre de la tarea debe ser un texto.',
        'nombre.max' => 'El nombre de la tarea no debe exceder los 255 caracteres.',

        'descripcion.required' => 'La descripción es obligatoria.',
        'descripcion.string' => 'La descripción debe ser un texto.',

        'actividad.required' => 'La actividad es obligatoria.',
        'actividad.in' => 'La actividad seleccionada no es válida. Debe ser Configuración, Desarrollo, Prueba, Diseño u OtroTipo.',
        ]);

        // Asociar tarea con la historia
        $historia->tareas()->create($validatedData);

        return redirect()->route('tareas.show', $historia->id)->with('success', 'Tarea creada con éxito.');
    }

    public function edit(Historia $historia, Tarea $tarea)
    {
        $tablero = $this->cargarTablero($historia);
        $users = User::all();
        return view('tareas.edit', compact('historia', 'tarea', 'users'));
    }

    public function update(Request $request, Historia $historia, Tarea $tarea)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string', 
            'actividad' => 'required|in:Configuracion,Desarrollo,Prueba,Diseño,OtroTipo',

            ], [
        'nombre.required' => 'El nombre de la tarea es obligatorio.',
        'nombre.string' => 'El nombre de la tarea debe ser un texto.',
        'nombre.max' => 'El nombre de la tarea no debe exceder los 255 caracteres.',

        'descripcion.required' => 'La descripción es obligatoria.',
        'descripcion.string' => 'La descripción debe ser un texto.',

        'actividad.required' => 'La actividad es obligatoria.',
        'actividad.in' => 'La actividad seleccionada no es válida. Debe ser Configuración, Desarrollo, Prueba, Diseño u OtroTipo.',
    ]);
        

        $tarea->update($validatedData);

        return redirect()->route('tareas.show', $historia->id)->with('success', 'Tarea actualizada con éxito.');
    }

    public function destroy(Historia $historia, Tarea $tarea)
    {
        $tarea->delete();

        return redirect()->route('tareas.show', $historia->id)->with('success', 'Tarea eliminada con éxito.');
    }

    public function lista(Historia $historia)
    {
        $tablero = $this->cargarTablero($historia);
        $tareas = $historia->tareas()->with('user')->paginate(5);

        return view('tareas.show', compact('tareas', 'historia'));
    }
    public function toggleCompletada(Request $request, $id)
{
    $tarea = Tarea::findOrFail($id);
    $tarea->completada = !$tarea->completada;
    $tarea->save();

    return response()->json(['success' => true]);
}

public function showDetalle(Historia $historia)
{
    // Cargar las tareas relacionadas
    $tareas = $historia->tareas()->with('user')->get();

    // Retornar la vista con las dos variables
    return view('historias.detalle', compact('historia', 'tareas'));
}

}