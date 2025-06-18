<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Historia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BacklogController extends Controller
{
    public function index(Project $project)
    {
        $project->load('tablero');
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
            'tablero' => $proyecto->tablero,
        ]);
    }


    public function backlog(Project $project)
    {
        return view('backlog.index', [
            'project' => $project,
            'tablero' => $project->tablero
        ]);
        return view('backlog.index', [
            'project' => $project,
            'currentProject' => $project,
        ]);
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

    /**
     * Export the backlog to PDF.
     */
    public function exportPdf(Project $project)
    {
        $project->load(['tablero', 'sprints']);
        $sprintId = request('sprint_id');
        
        $historias = Historia::with(['columna', 'sprints', 'usuario', 'tareas'])
            ->where('proyecto_id', $project->id)
            ->when($sprintId, function ($query) use ($sprintId) {
                $query->where('sprint_id', $sprintId);
            })
            ->orderBy('prioridad', 'desc') // Ordenar por prioridad
            ->get();
            
        // Agrupar historias por estado (columna)
        $historiasPorEstado = $historias->groupBy(function($historia) {
            return $historia->columna ? $historia->columna->nombre : 'Sin asignar';
        });

        $pdf = PDF::loadView('pdf.backlog_pdf', [
            'proyecto' => $project,
            'historias' => $historias,
            'historiasPorEstado' => $historiasPorEstado,
            'sprintId' => $sprintId,
            'fechaGeneracion' => now()->format('d/m/Y H:i')
        ]);
        
        $filename = 'backlog_' . $project->nombre . '_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }
}
