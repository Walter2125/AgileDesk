<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Historia;
use App\Models\Columna;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request, $projectId = null)
    {
        // Lógica para obtener el projectId - ACTUALIZADA
        if (!$projectId) {
            $projectId = $request->query('project_id');
        }
        if (!$projectId) {
            $projectId = $request->route('projectId'); // Obtener del parámetro de ruta
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

        // Obtener proyecto y validar
        $project = $projectId ? Project::with('users')->find($projectId) : null;
        
        if (!$projectId || !$project) {
            return view('users.colaboradores.homeuser', [
                'estadisticas' => collect(),
                'proyectos_usuario' => Auth::check() ? Auth::user()->projects : collect(),
                'proyecto_actual' => null,
                'user_contributions' => [],
                'total_historias_proyecto' => 0,
                'total_tareas_proyecto' => 0,
                'total_listo' => 0,
                'total_progreso' => 0,
                'total_pendientes' => 0,
                'total_contribuciones_proyecto' => 0
            ]);
        }

        // Obtener usuarios miembros (no admin) - MEJORADO
        $usuarios = $project->users()
            ->where('usertype', '!=', 'admin')
            ->with(['historias' => function($q) use ($projectId) {
                $q->where('proyecto_id', $projectId)
                  ->with(['columna', 'tareas' => function($subQ) {
                      $subQ->with('user:id,name,photo');
                  }]);
            }])
            ->get();

        // Debug: Verificar que se cargan los usuarios
        Log::info("Usuarios encontrados en el proyecto: " . $usuarios->count());

        // Verificar si el usuario actual es miembro
        if (!Auth::check() || !$usuarios->pluck('id')->contains(Auth::id())) {
            return view('users.colaboradores.homeuser', [
                'estadisticas' => collect(),
                'proyectos_usuario' => Auth::user()->projects,
                'proyecto_actual' => $project,
                'user_contributions' => [],
                'total_historias_proyecto' => 0,
                'total_tareas_proyecto' => 0,
                'total_listo' => 0,
                'total_progreso' => 0,
                'total_pendientes' => 0,
                'total_contribuciones_proyecto' => 0
            ]);
        }

        // Calcular estadísticas
        $estadisticas = $usuarios->map(function($usuario) use ($projectId) {
            $historiasValidas = $usuario->historias
                ->where('proyecto_id', $projectId)
                ->where('columna', '!=', null)
                ->unique('id');

            $porColumna = [
                'Pendiente' => 0,
                'En progreso' => 0,
                'Listo' => 0,
            ];

            foreach ($historiasValidas as $historia) {
                $nombreColumna = $historia->columna->nombre;
                if (isset($porColumna[$nombreColumna])) {
                    $porColumna[$nombreColumna]++;
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
            ];
        });

        // Preparar datos para el modal - CORREGIDO
        $userContributions = [];
        foreach ($usuarios as $usuario) {
            // Obtener historias válidas del usuario para este proyecto
            $historiasValidas = $usuario->historias
                ->where('proyecto_id', $projectId)
                ->where('columna', '!=', null)
                ->unique('id');

            // Debug: Log para verificar datos
            Log::info("Usuario {$usuario->name} - Historias encontradas: " . $historiasValidas->count());

            $userContributions[$usuario->id] = [
                'user' => [
                    'id' => $usuario->id,
                    'name' => $usuario->name,
                    'email' => $usuario->email,
                    'photo' => $usuario->photo ? asset('storage/'.$usuario->photo) : null
                ],
                'stories' => $historiasValidas->values()->map(function($historia) {
                    Log::info("Procesando historia: {$historia->nombre}");
                    
                    // Verificar que la columna existe
                    if (!$historia->columna) {
                        Log::warning("Historia {$historia->id} no tiene columna asignada");
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
                            // Verificar si la tarea tiene usuario asignado
                            $tareaData = [
                                'id' => $tarea->id,
                                'nombre' => $tarea->nombre,
                                'completada' => (bool)$tarea->completada,
                                'user' => null // Por defecto null
                            ];
                            
                            // Solo agregar datos del usuario si existe
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
                })->filter()->toArray() // Filtrar nulls y convertir a array
            ];
        }

        // Calcular totales del proyecto
        $totalHistoriasProyecto = $estadisticas->sum('total_historias');
        $totalTareasProyecto = $estadisticas->sum('total_tareas');
        $totalListo = $estadisticas->sum('listo');
        $totalProgreso = $estadisticas->sum('progreso');
        $totalPendientes = $estadisticas->sum('pendientes');

        // Debug: Verificar datos finales
        Log::info("Datos finales para vista:", [
            'usuarios_count' => count($userContributions),
            'estadisticas_count' => $estadisticas->count(),
            'total_historias' => $totalHistoriasProyecto,
            'user_contributions_keys' => array_keys($userContributions),
            'sample_user_data' => !empty($userContributions) ? reset($userContributions) : 'No hay datos'
        ]);

        // Asegurar que userContributions no esté vacío, al menos con estructura básica
        if (empty($userContributions) && !empty($usuarios)) {
            Log::warning("userContributions vacío, creando estructura básica");
            foreach ($usuarios as $usuario) {
                $userContributions[$usuario->id] = [
                    'user' => [
                        'id' => $usuario->id,
                        'name' => $usuario->name,
                        'email' => $usuario->email,
                        'photo' => $usuario->photo ? asset('storage/'.$usuario->photo) : null
                    ],
                    'stories' => [] // Sin historias, pero al menos estructura básica
                ];
            }
        }

        return view('users.colaboradores.homeuser', [
            'estadisticas' => $estadisticas,
            'proyectos_usuario' => Auth::user()->projects,
            'proyecto_actual' => $project,
            'user_contributions' => $userContributions,
            'total_historias_proyecto' => $totalHistoriasProyecto,
            'total_tareas_proyecto' => $totalTareasProyecto,
            'total_listo' => $totalListo,
            'total_progreso' => $totalProgreso,
            'total_pendientes' => $totalPendientes,
            'total_contribuciones_proyecto' => $totalHistoriasProyecto + $totalTareasProyecto
        ]);
    }
}