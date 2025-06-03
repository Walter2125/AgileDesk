<?php

namespace App\Http\Controllers;
use App\Models\Sprint;
use App\Models\Columna;
use App\Models\Project;
use App\Models\Tablero;
use Illuminate\Http\Request;

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
            // Filtra las historias de cada columna según el sprint_id
            foreach ($tablero->columnas as $columna) {
                $columna->historias = $columna->historias()->where('sprint_id', $sprintId)->get();
            }
        } else {
            // Si no hay sprint_id, muestra todas las historias como ahora
            foreach ($tablero->columnas as $columna) {
                $columna->historias = $columna->historias;
            }
        }


    return view('users.admin.tablero', compact('tablero', 'project'));
    }



    return view('users.admin.tablero', compact('project', 'tablero', 'historiaEncontrada'));


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
