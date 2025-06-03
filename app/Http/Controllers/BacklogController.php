<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Historia;
use App\Models\Sprint;
use Illuminate\Http\Request;

class BacklogController extends Controller
{
    /**
     * Muestra el backlog del proyecto con historias, opcionalmente filtradas por sprint.
     */
    public function index(Request $request, $projectId)
    {
        // Obtener el proyecto
        $proyecto = Project::with(['sprints', 'historias.columna'])->findOrFail($projectId);
        
        // Obtener el sprint seleccionado (si existe)
        $sprintId = $request->get('sprint_id');
        
        // Construir la consulta base para las historias del proyecto
        $historiasQuery = Historia::where('proyecto_id', $projectId)
            ->with(['columna', 'sprints']);
        
        // Filtrar por sprint si se especifica
        if ($sprintId) {
            $historiasQuery->where('sprint_id', $sprintId);
        }
        
        // Obtener las historias ordenadas por prioridad
        $historias = $historiasQuery->orderBy('prioridad', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('users.admin.backlog', compact('proyecto', 'historias', 'sprintId'));
    }
}
