<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Historia;

class BacklogController extends Controller
{
    public function index(Project $project)
    {
        $sprintId = request('sprint_id');

        $proyecto = $project->load('sprints');

        $historias = Historia::with(['columna', 'sprints'])
            ->where('proyecto_id', $project->id)
            ->when($sprintId, function ($query) use ($sprintId) {
                $query->where('sprint_id', $sprintId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('users.admin.backlog', [
            'proyecto' => $proyecto,
            'historias' => $historias,
            'sprintId' => $sprintId,
            'currentProject' => $project, // 👈 Esto es lo que necesita tu layout
        ]);
    }


    public function backlog(Project $project)
    {
        return view('backlog.index', ['project' => $project]);
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
        //
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
