<?php

namespace App\Http\Controllers;

use App\Models\HistorialCambio;
use Illuminate\Http\Request;
use App\Models\Project; 

class HistorialCambioController extends Controller
{
    /**
     * Muestra una lista del historial de cambios.
     */
    public function index(Request $request)
    {
        // Opcional: filtrar por usuario, acción o sprint
        $query = HistorialCambio::query();

        if ($request->filled('usuario')) {
            $query->where('usuario', 'like', '%' . $request->usuario . '%');
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('sprint')) {
            $query->where('sprint', $request->sprint);
        }

        // Ordena por fecha descendente y pagina
        $historial = $query->orderBy('fecha', 'desc')->paginate(10);

        return view('historial.index', compact('historial'));
    }
    

    public function porProyecto(Project $project, Request $request)
{
    if (!auth()->user()->projects->contains($project->id)) {
        abort(403, 'No tienes acceso a este proyecto');
    }

    $query = HistorialCambio::where('proyecto_id', $project->id)
        ->with('proyecto') // Carga la relación para evitar N+1
        ->orderBy('fecha', 'desc');

    if ($request->filled('busqueda')) {
        $searchTerm = '%' . $request->input('busqueda') . '%';
        $query->where(function ($q) use ($searchTerm) {
            $q->where('usuario', 'LIKE', $searchTerm)
              ->orWhere('accion', 'LIKE', $searchTerm)
              ->orWhere('detalles', 'LIKE', $searchTerm)
              ->orWhere('sprint', 'LIKE', $searchTerm)
              ->orWhereHas('proyecto', function ($q) use ($searchTerm) {
                  $q->where('name', 'LIKE', $searchTerm);
              });
        });
    }

    $historial = $query->paginate(10)->appends($request->query());

    return view('users.colaboradores.historial', compact('historial', 'project'));
}


}