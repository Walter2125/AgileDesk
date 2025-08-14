<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\Project;
use App\Models\Tablero;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function index($projectId)
    {


        $proyecto = Project::with('sprints')->findOrFail($projectId);
        return view('users.admin.sprint', compact('proyecto'));
    }


    public function show($projectId, Request $request)
    {
        $tablero = Tablero::with(['sprints', 'columnas.historias'])->where('proyecto_id', $projectId)->firstOrFail();
        $sprintId = $request->query('sprint_id');

        // Filtrar historias por sprint si hay
        if (!empty($sprintId)) {
            $tablero->columnas->each(function ($columna) use ($sprintId) {
                $columna->historias = $columna->historias->where('sprint_id', $sprintId)->values();
            });
        } else {
            $tablero->columnas->each(function ($columna) {
                $columna->historias = $columna->historias->values(); // todas
            });
        }

        // Pasar el sprint seleccionado a la vista
        return view('users.admin.tablero', [
            'tablero' => $tablero,
            'sprintId' => $sprintId
        ]);
    }





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

        $project = Project::findOrFail($projectId);

        // Obtener el último sprint por tablero
        $ultimoSprint = Sprint::where('tablero_id', $request->tablero_id)
            ->orderByDesc('fecha_fin')
            ->first();

        if ($ultimoSprint && $request->fecha_inicio <= $ultimoSprint->fecha_fin) {
            return back()->withErrors([
                'fecha_inicio' => 'La fecha de inicio del nuevo sprint debe ser posterior a la fecha de fin del sprint anterior (' . $ultimoSprint->fecha_fin . ').'
            ])->withInput();
        }

        $ultimoNumero = Sprint::where('tablero_id', $request->tablero_id)->max('numero_sprint') ?? 0;

        Sprint::create([
            'nombre' => 'Sprint ' . ($ultimoNumero + 1),
            'numero_sprint' => $ultimoNumero + 1,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'tablero_id' => $request->tablero_id,
            'proyecto_id' => $projectId,
        ]);

        return redirect()->route('tableros.show', $projectId)->with('success', 'Sprint creado correctamente.');
    }

    public function edit(Sprint $sprint)
    {
        $currentProject = $sprint->proyecto; // la relación debe estar definida
        return view('users.admin.edit_sprint', compact('sprint', 'currentProject'));
    }


    public function update(Request $request, Sprint $sprint)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        $sprint->update([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return redirect()->route('sprints.index', $sprint->proyecto_id)->with('success', 'Sprint actualizado correctamente.');
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
