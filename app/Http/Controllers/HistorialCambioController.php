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

    $query = HistorialCambio::where('proyecto_id', $project->id);

    if ($request->filled('busqueda')) {
        $busqueda = $request->input('busqueda');
        $query->where(function ($q) use ($busqueda) {
            $q->where('usuario', 'like', "%{$busqueda}%")
              ->orWhere('accion', 'like', "%{$busqueda}%")
              ->orWhere('detalles', 'like', "%{$busqueda}%")
              ->orWhere('sprint', 'like', "%{$busqueda}%");
        });
    }

    $historial = $query->orderBy('fecha', 'desc')->paginate(10);
    $historial->appends($request->only('busqueda'));

    return view('users.colaboradores.historial', compact('historial', 'project'));
}



}
