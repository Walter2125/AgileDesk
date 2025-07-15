<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Historia;
use App\Models\Columna;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\HistorialCambio;
use App\Models\Tarea;


class UserController extends Controller
{
   public function index(Request $request, $projectId = null)
{
    if (!$projectId) {
        $projectId = $request->query('project_id');
    }

    if (!$projectId) {
        $projectId = session('selected_project_id');
    }

    if (!$projectId && Auth::check()) {
        $firstProject = Auth::user()->projects()->first();
        if ($firstProject) {
            $projectId = $firstProject->id;
        }
    }

    if ($projectId) {
        session(['selected_project_id' => $projectId]);
    }

    if (!$projectId) {
        return view('users.colaboradores.homeuser', [
            'estadisticas' => collect(),
            'proyectos_usuario' => Auth::check() ? Auth::user()->projects : collect(),
            'proyecto_actual' => null,
            'historial' => collect(), // 👈 importante
        ]);
    }

    $project = Project::with('users')->find($projectId);

    if (!$project) {
        return view('users.colaboradores.homeuser', [
            'estadisticas' => collect(),
            'proyectos_usuario' => Auth::check() ? Auth::user()->projects : collect(),
            'proyecto_actual' => null,
            'historial' => collect(), // 👈 importante
        ]);
    }

    $usuarios = $project->users->where('usertype', '!=', 'admin');

    if (!Auth::check() || !$usuarios->pluck('id')->contains(Auth::id())) {
        return view('users.colaboradores.homeuser', [
            'estadisticas' => collect(),
            'proyectos_usuario' => Auth::user()->projects,
            'proyecto_actual' => $project,
            'historial' => collect(), // 👈 importante
        ]);
    }

    $usuarios = $usuarios->load(['historias' => function($q) use ($projectId) {
        $q->where('proyecto_id', $projectId)->with('columna');
    }]);

    $estadisticas = $usuarios->map(function($usuario) {
        $total = $usuario->historias->count();
        $porColumna = [
            'Pendiente' => 0,
            'En progreso' => 0,
            'Listo' => 0,
        ];
        foreach ($usuario->historias as $historia) {
            $columna = $historia->columna ? $historia->columna->nombre : null;
            if ($columna && isset($porColumna[$columna])) {
                $porColumna[$columna]++;
            }
        }
        return [
            'usuario' => $usuario,
            'total' => $total,
            'pendientes' => $porColumna['Pendiente'],
            'progreso' => $porColumna['En progreso'],
            'listo' => $porColumna['Listo'],
            'total_contribuciones' => $total,
        ];
    });

    // ✅ CARGAMOS EL HISTORIAL SOLO SI HAY PROYECTO
    $historial = HistorialCambio::where('proyecto_id', $project->id)
        ->orderBy('fecha', 'desc')
        ->take(10)
        ->get();

    $total_historias_proyecto = Historia::where('proyecto_id', $projectId)->count();
    $total_contribuciones_proyecto = Historia::where('proyecto_id', $projectId)->count();
    $total_tareas_proyecto = Tarea::where('proyecto_id', $projectId)->count();


    $total_listo = Historia::where('proyecto_id', $projectId)
    ->whereHas('columna', function ($q) {
        $q->where('nombre', 'Listo');
    })->count();

    $total_progreso = Historia::where('proyecto_id', $projectId)
    ->whereHas('columna', function ($q) {
        $q->where('nombre', 'En progreso');
    })->count();

    $total_pendientes = Historia::where('proyecto_id', $projectId)
    ->whereHas('columna', function ($q) {
        $q->where('nombre', 'Pendiente');
    })->count();


    return view('users.colaboradores.homeuser', [
        'estadisticas' => $estadisticas,
        'proyectos_usuario' => Auth::user()->projects,
        'proyecto_actual' => $project,
        'total_historias_proyecto' => $total_historias_proyecto,
        'total_listo' => $total_listo,
        'total_progreso' => $total_progreso,
        'total_pendientes' => $total_pendientes,
        'total_tareas_proyecto' => $total_tareas_proyecto,
        'total_contribuciones_proyecto' => $total_contribuciones_proyecto,
        'historial' => $historial
    ]);
}
}
