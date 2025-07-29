<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprint;
use App\Models\HistorialCambio;
use App\Models\Project;
use App\Models\User;
use App\Models\Historia;
use App\Models\Columna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index(Request $request, $projectId = null)
    {
        // Obtener datos administrativos básicos
        $usuarios = User::where('usertype', '!=', 'admin')->paginate(5, ['*'], 'usuarios_page');
        $proyectos = Project::with('creator', 'users')->paginate(5, ['*'], 'proyectos_page');
        $historial = HistorialCambio::paginate(5, ['*'], 'historial_page');
        $sprints = Sprint::with('proyecto')->paginate(5, ['*'], 'sprints_page');

        // Lógica para estadísticas de proyecto (similar a UserController)
        if (!$projectId) {
            $projectId = $request->query('project_id');
        }
        if (!$projectId) {
            $projectId = $request->route('projectId');
        }
        if (!$projectId) {
            $projectId = session('admin_selected_project_id');
        }
        if (!$projectId) {
            $firstProject = Project::first();
            if ($firstProject) {
                $projectId = $firstProject->id;
            }
        }
        if ($projectId) {
            session(['admin_selected_project_id' => $projectId]);
        }

        // Obtener proyecto y validar
        $project = $projectId ? Project::with('users')->find($projectId) : null;
        
        if (!$projectId || !$project) {
            return view('users.admin.homeadmin', array_merge(
                compact('usuarios', 'proyectos', 'historial', 'sprints'),
                [
                    'estadisticas' => collect(),
                    'proyectos_usuario' => Project::all(), // Admin puede ver todos
                    'proyecto_actual' => null,
                    'user_contributions' => [],
                    'columnas_ordenadas' => [],
                    'total_historias_proyecto' => 0,
                    'total_tareas_proyecto' => 0,
                    'total_listo' => 0,
                    'total_progreso' => 0,
                    'total_pendientes' => 0,
                    'total_en_proceso' => 0,
                    'total_terminadas' => 0,
                    'total_contribuciones_proyecto' => 0
                ]
            ));
        }

        // Obtener usuarios miembros (no admin) del proyecto
        $usuariosProyecto = $project->users()
            ->where('usertype', '!=', 'admin')
            ->with(['historias' => function($q) use ($projectId) {
                $q->where('proyecto_id', $projectId)
                  ->with(['columna', 'tareas' => function($subQ) {
                      $subQ->with('user:id,name,photo');
                  }]);
            }])
            ->get();

        // Obtener las columnas del tablero ordenadas por posición
        $tablero = $project->tablero;
        $columnas = $tablero ? $tablero->columnas()->orderBy('posicion', 'asc')->get() : collect();
        $primeraColumna = $columnas->first();
        $ultimaColumna = $columnas->last();

        // Calcular estadísticas
        $estadisticas = $usuariosProyecto->map(function($usuario) use ($projectId, $primeraColumna, $ultimaColumna, $columnas) {
            $historiasValidas = $usuario->historias
                ->where('proyecto_id', $projectId)
                ->where('columna', '!=', null)
                ->unique('id');

            $porColumna = [
                'Pendiente' => 0,
                'En progreso' => 0,
                'Listo' => 0,
            ];

            $contadores = [
                'en_proceso' => 0,
                'terminadas' => 0,
            ];

            foreach ($historiasValidas as $historia) {
                $nombreColumna = $historia->columna->nombre;
                if (isset($porColumna[$nombreColumna])) {
                    $porColumna[$nombreColumna]++;
                }

                // Clasificar por posición en el tablero (solo si hay 3 o más columnas)
                if ($columnas->count() >= 3) {
                    if ($ultimaColumna && $historia->columna_id == $ultimaColumna->id) {
                        $contadores['terminadas']++;
                    } elseif ($primeraColumna && $historia->columna_id != $primeraColumna->id && $historia->columna_id != $ultimaColumna->id) {
                        $contadores['en_proceso']++;
                    }
                }
            }

            $totalTareas = $historiasValidas->sum(fn($h) => $h->tareas->count());

            return [
                'usuario' => $usuario,
                'total_historias' => $historiasValidas->count(),
                'total_tareas' => $totalTareas,
                'total_contribuciones' => $historiasValidas->count() + $totalTareas,
                'pendientes' => $porColumna['Pendiente'],
                'progreso' => $porColumna['En progreso'],
                'listo' => $porColumna['Listo'],
                'en_proceso' => $contadores['en_proceso'],
                'terminadas' => $contadores['terminadas'],
            ];
        });

        // Preparar datos para el modal
        $userContributions = [];
        foreach ($usuariosProyecto as $usuario) {
            $historiasValidas = $usuario->historias
                ->where('proyecto_id', $projectId)
                ->where('columna', '!=', null)
                ->unique('id');

            $userContributions[$usuario->id] = [
                'user' => [
                    'id' => $usuario->id,
                    'name' => $usuario->name,
                    'email' => $usuario->email,
                    'photo' => $usuario->photo ? asset('storage/'.$usuario->photo) : null
                ],
                'stories' => $historiasValidas->values()->map(function($historia) {
                    if (!$historia->columna) {
                        return null;
                    }

                    return [
                        'id' => $historia->id,
                        'nombre' => $historia->nombre,
                        'descripcion' => $historia->descripcion ?? 'Sin descripción',
                        'columna' => [
                            'id' => $historia->columna->id,
                            'nombre' => $historia->columna->nombre
                        ],
                        'tareas' => $historia->tareas->map(function($tarea) {
                            $tareaData = [
                                'id' => $tarea->id,
                                'nombre' => $tarea->nombre,
                                'completada' => (bool)$tarea->completada,
                                'user' => null
                            ];
                            
                            if ($tarea->user) {
                                $tareaData['user'] = [
                                    'id' => $tarea->user->id,
                                    'name' => $tarea->user->name,
                                    'photo' => $tarea->user->photo ? asset('storage/'.$tarea->user->photo) : null
                                ];
                            }
                            
                            return $tareaData;
                        })->toArray()
                    ];
                })->filter()->toArray()
            ];
        }

        // Calcular totales del proyecto (TODAS las historias, incluyendo las sin estado)
        $todasLasHistorias = Historia::where('proyecto_id', $projectId)
            ->with(['columna', 'tareas'])
            ->get();
        
        $totalHistoriasProyecto = $todasLasHistorias->count();
        $totalTareasProyecto = $todasLasHistorias->sum(fn($h) => $h->tareas->count());

        // Calcular contadores por posición de columna solo para historias CON estado (solo si hay 3+ columnas)
        $historiasConEstado = $todasLasHistorias->whereNotNull('columna_id');
        $totalEnProceso = 0;
        $totalTerminadas = 0;

        if ($columnas->count() >= 3) {
            foreach ($historiasConEstado as $historia) {
                if ($ultimaColumna && $historia->columna_id == $ultimaColumna->id) {
                    $totalTerminadas++;
                } elseif ($primeraColumna && $historia->columna_id != $primeraColumna->id && $historia->columna_id != $ultimaColumna->id) {
                    $totalEnProceso++;
                }
            }
        }

        // Los totales por usuario siguen siendo solo para estadísticas individuales
        $totalListo = $estadisticas->sum('listo');
        $totalProgreso = $estadisticas->sum('progreso');
        $totalPendientes = $estadisticas->sum('pendientes');

        // Asegurar estructura básica si está vacío
        if (empty($userContributions) && !empty($usuariosProyecto)) {
            foreach ($usuariosProyecto as $usuario) {
                $userContributions[$usuario->id] = [
                    'user' => [
                        'id' => $usuario->id,
                        'name' => $usuario->name,
                        'email' => $usuario->email,
                        'photo' => $usuario->photo ? asset('storage/'.$usuario->photo) : null
                    ],
                    'stories' => []
                ];
            }
        }

        return view('users.admin.homeadmin', array_merge(
            compact('usuarios', 'proyectos', 'historial', 'sprints'),
            [
                'estadisticas' => $estadisticas,
                'proyectos_usuario' => Project::all(), // Admin puede ver todos los proyectos
                'proyecto_actual' => $project,
                'user_contributions' => $userContributions,
                'columnas_ordenadas' => $columnas->toArray(), // Pasar columnas ordenadas
                'total_historias_proyecto' => $totalHistoriasProyecto,
                'total_tareas_proyecto' => $totalTareasProyecto,
                'total_listo' => $totalListo,
                'total_progreso' => $totalProgreso,
                'total_pendientes' => $totalPendientes,
                'total_en_proceso' => $totalEnProceso,
                'total_terminadas' => $totalTerminadas,
                'total_contribuciones_proyecto' => $totalHistoriasProyecto + $totalTareasProyecto
            ]
        ));
    }
    
    /**
     * Soft delete a user
     */
    public function deleteUser(User $user)
    {
        // Verificar que no sea un admin
        if ($user->usertype === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin users.');
        }
        
        $user->delete();
        
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    
    /**
     * Restore a soft deleted user
     */
    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        // Verificar que el usuario esté soft deleted
        if (!$user->trashed()) {
            return redirect()->back()->with('error', 'El usuario no está eliminado.');
        }
        
        // Verificar que no sea un admin
        if ($user->usertype === 'admin') {
            return redirect()->back()->with('error', 'No se pueden restaurar usuarios admin.');
        }
        
        $userName = $user->name;
        $user->restore();
        
        return redirect()->back()->with('success', "Usuario {$userName} restaurado exitosamente.");
    }
    
    /**
     * Get only active users (not soft deleted)
     */
    public function getActiveUsers()
    {
        return User::where('usertype', '!=', 'admin')->paginate(10);
    }
    
    /**
     * Get only soft deleted users
     */
    public function getDeletedUsers()
    {
        return User::onlyTrashed()->where('usertype', '!=', 'admin')->paginate(10);
    }
    
    /**
     * Show deleted users history
     */
    public function deletedUsers()
    {
        $deletedUsers = User::onlyTrashed()
            ->where('usertype', '!=', 'admin')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
            
        return view('users.admin.deleted-users', compact('deletedUsers'));
    }
    
    /**
     * Permanently delete a user
     */
    public function permanentDeleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        // Verificar que el usuario esté soft deleted
        if (!$user->trashed()) {
            return redirect()->back()->with('error', 'User is not deleted.');
        }
        
        // Verificar que no sea un admin
        if ($user->usertype === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin users.');
        }
        
        $userName = $user->name;
        $user->forceDelete();
        
        return redirect()->back()->with('success', 'User permanently deleted successfully.');
    }
}
