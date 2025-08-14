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

        $tablero = $project->tablero()
            ->with(['columnas.historias', 'sprints'])
            ->firstOrFail();

        $sprintId = request('sprint_id');

        if ($sprintId) {
            // Filtrar solo por el sprint seleccionado
            foreach ($tablero->columnas as $columna) {
                $columna->historias = $columna->historias()
                    ->where('sprint_id', $sprintId)
                    ->get();
            }
        } else {
            // Mostrar todas las historias sin filtrar
            foreach ($tablero->columnas as $columna) {
                $columna->historias = $columna->historias()->get();
            }
        }

        return view('users.admin.tablero', compact('tablero', 'project', 'sprintId'));
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
