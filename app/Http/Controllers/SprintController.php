<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\Project;
use App\Models\Tablero;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    /**
     * Almacena un nuevo sprint asociado a un proyecto y tablero.
     */
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'tablero_id' => 'required|exists:tableros,id',
        ]);

        // Obtener el proyecto (por validación y contexto)
        $project = Project::findOrFail($projectId);

        // Obtener el número de sprint más alto ya existente
        $ultimoNumero = Sprint::where('tablero_id', $request->tablero_id)->max('numero_sprint') ?? 0;

        // Crear el nuevo sprint
        Sprint::create([
            'nombre' => 'Sprint ' . ($ultimoNumero + 1),
            'numero_sprint' => $ultimoNumero + 1,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'tablero_id' => $request->tablero_id,
            'proyecto_id' => $projectId,
        ]);

        // Redirige a la vista del tablero para evitar error de variable no definida
        return redirect()->route('tableros.show', $projectId)->with('success', 'Sprint creado correctamente.');
    }

    /**
     * Elimina un sprint específico (si usas esta función).
     */
    public function destroy(Sprint $sprint)
    {
        $sprint->delete();
        return back()->with('success', 'Sprint eliminado correctamente.');
    }

    /**
     * (Opcional) Devuelve las historias asociadas a un sprint en formato JSON.
     * Útil si más adelante deseas hacer filtros dinámicos con JavaScript.
     */
    public function historiasPorSprint(Sprint $sprint)
    {
        $historias = $sprint->historias()->with('columna')->get();

        return response()->json($historias);
    }
}
