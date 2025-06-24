<?php

namespace App\Http\Controllers;
use App\Models\Sprint;
use App\Models\Columna;
use App\Models\Project;
use App\Models\Tablero;
use Illuminate\Http\Request;
use Carbon\Carbon;


class TableroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */


    public function show($projectId)
    {
        $project = Project::findOrFail($projectId);
        $tablero = $project->tablero()->with(['columnas.historias', 'sprints'])->first();

        // Obtener el sprint_id de la URL (si existe)
        $sprintId = request('sprint_id');

        if ($sprintId) {
            $sprintActivo = $tablero->sprints->firstWhere('id', $sprintId);
        } else {
            // Obtener la fecha actual
            $hoy = Carbon::now()->format('Y-m-d');

            // Buscar sprint activo por fecha
            $sprintActivo = $tablero->sprints
                ->where('fecha_inicio', '<=', $hoy)
                ->where('fecha_fin', '>=', $hoy)
                ->first();
        }

        // Si hay sprint activo, filtramos historias por ese sprint
        if ($sprintActivo) {
            foreach ($tablero->columnas as $columna) {
                $columna->historias = $columna->historias()
                    ->where('sprint_id', $sprintActivo->id)
                    ->get();
            }
        } else {
            // Si no hay sprint activo ni seleccionado, mostramos todas las historias
            foreach ($tablero->columnas as $columna) {
                $columna->historias = $columna->historias;
            }
        }

        return view('users.admin.tablero', compact('tablero', 'project', 'sprintActivo'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
