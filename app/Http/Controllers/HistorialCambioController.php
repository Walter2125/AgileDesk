<?php

namespace App\Http\Controllers;

use App\Models\HistorialCambio;
use Illuminate\Http\Request;
use App\Models\Project; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    /**
     * Vista de historial del sistema completo (Solo superadministradores)
     */
    public function sistema(Request $request)
    {
        // Verificar que el usuario sea superadministrador
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta vista.');
        }

        // Obtener todos los registros para DataTables
        $historial = HistorialCambio::with('proyecto')
            ->orderBy('created_at', 'desc')
            ->get();

        // Obtener datos para los filtros (aunque no se usen en la nueva implementación)
        $proyectos = Project::orderBy('name')->get();
        $acciones = HistorialCambio::select('accion')
            ->distinct()
            ->orderBy('accion')
            ->pluck('accion');

        // Estadísticas rápidas
        $stats = [
            'total_cambios' => HistorialCambio::count(),
            'cambios_hoy' => HistorialCambio::whereDate('created_at', today())->count(),
            'cambios_semana' => HistorialCambio::where('created_at', '>=', now()->subDays(7))->count(),
            'usuarios_activos' => HistorialCambio::distinct('usuario')->count('usuario'),
        ];

        return view('users.admin.historial-sistema', compact('historial', 'proyectos', 'acciones', 'stats'));
    }

    /**
     * Limpiar historial del sistema por antigüedad (Solo superadministradores)
     */
    public function limpiarHistorial(Request $request)
    {
        // Verificar que el usuario sea superadministrador
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $request->validate([
            'dias' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $diasAntiguedad = $request->input('dias');
            $fechaLimite = now()->subDays($diasAntiguedad);
            
            // Contar registros antes de eliminar
            $totalRegistros = HistorialCambio::where('created_at', '<', $fechaLimite)->count();
            
            if ($totalRegistros > 0) {
                // Eliminar registros antiguos
                HistorialCambio::where('created_at', '<', $fechaLimite)->delete();

                // Registrar la acción de limpieza
                HistorialCambio::create([
                    'fecha' => now(),
                    'usuario' => Auth::user()->name,
                    'accion' => 'Limpieza de historial',
                    'detalles' => "Se eliminaron {$totalRegistros} registros del historial con más de {$diasAntiguedad} días de antigüedad",
                    'sprint' => null,
                    'proyecto_id' => null
                ]);

                $mensaje = "Historial limpiado exitosamente. Se eliminaron {$totalRegistros} registros con más de {$diasAntiguedad} días de antigüedad.";
            } else {
                $mensaje = "No se encontraron registros con más de {$diasAntiguedad} días de antigüedad para eliminar.";
            }

            DB::commit();

            return redirect()->route('historial.sistema')->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('historial.sistema')
                ->with('error', 'Error al limpiar el historial: ' . $e->getMessage());
        }
    }
   public function porProyecto(Project $project, Request $request)
{
    $user = Auth::user();

    if (!$user->isAdmin() && !$user->projects->contains($project->id)) {
        abort(403, 'No tienes acceso a este proyecto');
    }

    $query = HistorialCambio::where('proyecto_id', $project->id)
        ->with('proyecto')
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

    if ($user->isAdmin()) {
        return view('users.admin.historial', compact('project', 'historial'));
    } else {
        return view('users.colaboradores.historial', compact('historial', 'project'));
    }
}

}