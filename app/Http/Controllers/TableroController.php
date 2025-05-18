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
  public function show(string $id)
    {
        $project = Project::findOrFail($id);
        $tablero = $project->tablero()->with('columnas')->firstOrFail();

        return view('users.admin.tablero', compact('project', 'tablero'));


        if ($tablero->columnas->where('es_backlog', true)->isEmpty()) {
            $tablero->columnas()->create([
                'nombre' => 'Backlog',
                'posicion' => 1,
                'es_backlog' => true,
            ]);
            return redirect()->route('tableros.show', $project->id);
        }



        return view('users.admin.tablero', compact('project', 'tablero'));

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
