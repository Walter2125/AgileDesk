<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Sprint;
use App\Models\HistorialCambio;
use App\Models\Project;
use App\Models\User;
use App\Models\Historia;
use App\Models\Columna;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests;
    use AuthorizesRequests;
    public function index(Request $request, $projectId = null)
    {
        // Obtener datos administrativos básicos
    $usuarios = User::where('usertype', '!=', 'admin')->get();
    $proyectos = Project::with('creator', 'users')->get();
    $historial = HistorialCambio::orderByDesc('created_at')->get();
    $sprints = Sprint::with('proyecto')->get();

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
            // Configurar breadcrumbs
            $breadcrumbs = [
                [
                    'label' => 'Dashboard Administrativo',
                    'url' => null, // Current page
                    'active' => true
                ]
            ];

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
                    'total_contribuciones_proyecto' => 0,
                    'breadcrumbs' => $breadcrumbs
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
                'total_contribuciones_proyecto' => $totalHistoriasProyecto + $totalTareasProyecto,
                'breadcrumbs' => [
                    [
                        'label' => 'Dashboard Administrativo',
                        'url' => null, // Current page
                        'active' => true
                    ]
                ]
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
            return redirect()->back()->with('error', 'No se pueden eliminar usuarios administradores.');
        }
        
        $user->delete();
        
        return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
    }
    
    /**
     * Restore a soft deleted user
     */
    // Método eliminado: restoreUser (mantenido por soft-deleted general: restoreItem)
    
    /**
     * Get only active users (not soft deleted)
     */
    public function getActiveUsers()
    {
        return User::where('usertype', '!=', 'admin')->paginate(10);
    }
    
    // Método eliminado: getDeletedUsers (reemplazado por el panel general de elementos eliminados)
    
    // Método eliminado: deletedUsers (vista específica obsoleta)
    
    // Método eliminado: permanentDeleteUser (mantenido por soft-deleted general: permanentDeleteItem)

    /**
     * Vista general de elementos soft-deleted
     */
    public function softDeletedItems(Request $request)
    {
        // Autorizar acceso
        if (!Gate::allows('soft-delete.viewAny')) {
            abort(403, 'No tienes permisos para acceder a esta vista.');
        }
        
        $type = $request->get('type', 'all');
        $search = $request->get('search', '');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $deletedItems = collect();

        // Obtener usuarios eliminados
        if ($type === 'all' || $type === 'users') {
            $users = User::onlyTrashed()
                ->where('usertype', '!=', 'admin')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    });
                })
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('deleted_at', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('deleted_at', '<=', $dateTo);
                })
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'type' => 'users',
                        'type_label' => 'Usuario',
                        'name' => $user->name,
                        'description' => $user->email,
                        'deleted_at' => $user->deleted_at,
                        'model' => $user
                    ];
                });
            $deletedItems = $deletedItems->merge($users);
        }

        // Obtener proyectos eliminados
        if ($type === 'all' || $type === 'projects') {
            $projects = Project::onlyTrashed()
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('codigo', 'like', "%{$search}%");
                    });
                })
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('deleted_at', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('deleted_at', '<=', $dateTo);
                })
                ->get()
                ->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'type' => 'projects',
                        'type_label' => 'Proyecto',
                        'name' => $project->name,
                        'description' => $project->descripcion ?? 'Sin descripción',
                        'deleted_at' => $project->deleted_at,
                        'model' => $project
                    ];
                });
            $deletedItems = $deletedItems->merge($projects);
        }

        // Obtener historias eliminadas
        if ($type === 'all' || $type === 'historias') {
            $historias = Historia::onlyTrashed()
                ->with(['proyecto'])
                ->when($search, function ($query) use ($search) {
                    $query->where('nombre', 'like', "%{$search}%");
                })
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('deleted_at', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('deleted_at', '<=', $dateTo);
                })
                ->get()
                ->map(function ($historia) {
                    return [
                        'id' => $historia->id,
                        'type' => 'historias',
                        'type_label' => 'Historia',
                        'name' => $historia->nombre,
                        'description' => "Proyecto: " . ($historia->proyecto->name ?? 'Sin proyecto'),
                        'deleted_at' => $historia->deleted_at,
                        'model' => $historia
                    ];
                });
            $deletedItems = $deletedItems->merge($historias);
        }

        // Obtener tareas eliminadas
        if ($type === 'all' || $type === 'tareas') {
            $tareas = Tarea::onlyTrashed()
                ->with(['historia'])
                ->when($search, function ($query) use ($search) {
                    $query->where('nombre', 'like', "%{$search}%");
                })
                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate('deleted_at', '>=', $dateFrom);
                })
                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate('deleted_at', '<=', $dateTo);
                })
                ->get()
                ->map(function ($tarea) {
                    return [
                        'id' => $tarea->id,
                        'type' => 'tareas',
                        'type_label' => 'Tarea',
                        'name' => $tarea->nombre,
                        'description' => "Historia: " . ($tarea->historia->nombre ?? 'Sin historia'),
                        'deleted_at' => $tarea->deleted_at,
                        'model' => $tarea
                    ];
                });
            $deletedItems = $deletedItems->merge($tareas);
        }

        // Ordenar por fecha de eliminación (más recientes primero)
        $deletedItems = $deletedItems->sortByDesc('deleted_at');

        // Implementar paginación manual
        $currentPage = $request->get('page', 1);
        $perPage = 15;
        $total = $deletedItems->count();
        $offset = ($currentPage - 1) * $perPage;
        
        // Crear paginador manual
        $deletedItemsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $deletedItems->slice($offset, $perPage)->values(),
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'pageName' => 'page',
            ]
        );
        
        // Preservar parámetros de filtro en la paginación
        $deletedItemsPaginated->appends($request->except('page'));

        // Configurar breadcrumbs
        $breadcrumbs = [
            [
                'label' => 'Dashboard',
                'url' => route('homeadmin')
            ],
            [
                'label' => 'Elementos Eliminados',
                'url' => null, // Current page
                'active' => true
            ]
        ];

        return view('admin.soft-deleted', compact('deletedItemsPaginated', 'type', 'search', 'dateFrom', 'dateTo', 'breadcrumbs'));
    }

    /**
     * Restaurar un elemento eliminado
     */
    public function restoreItem(Request $request, $model, $id)
    {
        // Autorizar acción
        if (!Gate::allows('soft-delete.restore')) {
            abort(403, 'No tienes permisos para restaurar elementos.');
        }
        
        try {
            $modelClass = $this->getModelClass($model);
            $item = $modelClass::onlyTrashed()->findOrFail($id);
            
            $item->restore();
            
            return redirect()->back()->with('success', $this->getModelNameInSpanish($model) . ' restaurado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al restaurar el elemento: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar permanentemente un elemento
     */
    public function permanentDeleteItem(Request $request, $model, $id)
    {
        // Autorizar acción
        if (!Gate::allows('soft-delete.forceDelete')) {
            abort(403, 'No tienes permisos para eliminar permanentemente elementos.');
        }
        
        try {
            $modelClass = $this->getModelClass($model);
            $item = $modelClass::onlyTrashed()->findOrFail($id);
            
            $item->forceDelete();
            
            return redirect()->back()->with('success', $this->getModelNameInSpanish($model) . ' eliminado permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el elemento: ' . $e->getMessage());
        }
    }

    /**
     * Obtener la clase del modelo según el tipo
     */
    private function getModelClass($type)
    {
        switch ($type) {
            case 'users':
                return User::class;
            case 'projects':
                return Project::class;
            case 'historias':
                return Historia::class;
            case 'tareas':
                return Tarea::class;
            default:
                throw new \InvalidArgumentException("Tipo de modelo no válido: {$type}");
        }
    }

    /**
     * Obtener el nombre en español del modelo según el tipo
     */
    private function getModelNameInSpanish($type)
    {
        switch ($type) {
            case 'users':
                return 'Usuario';
            case 'projects':
                return 'Proyecto';
            case 'historias':
                return 'Historia';
            case 'tareas':
                return 'Tarea';
            default:
                return ucfirst($type);
        }
    }

    /**
     * Eliminar un proyecto desde la vista de administración
     */
    public function deleteProject(Project $project)
    {
        try {
            $projectName = $project->name;
            $projectId = $project->id;
            
            // Verificar si el proyecto tiene datos asociados
            $hasHistorias = $project->historias()->count() > 0;
            $hasUsers = $project->users()->count() > 0;
            
            if ($hasHistorias || $hasUsers) {
                // Si tiene datos asociados, hacer soft delete
                $project->delete();

                // Registrar en el historial de cambios (usa helper que setea 'fecha' y 'usuario')
                HistorialCambio::registrar(
                    'delete',
                    "Proyecto '{$projectName}' eliminado (soft delete) - tenía datos asociados",
                    $projectId
                );

                Log::info("Proyecto eliminado (soft delete) por admin: {$projectName} (ID: {$projectId})");

                return redirect()->route('homeadmin')->with('warning',
                    "Proyecto '{$projectName}' eliminado exitosamente. Se mantuvieron los datos asociados y puede ser restaurado si es necesario.");
            } else {
                // Si no tiene datos asociados, eliminar permanentemente
                $project->forceDelete();

                // Registrar en historial también la eliminación permanente
                HistorialCambio::registrar(
                    'delete',
                    "Proyecto '{$projectName}' eliminado permanentemente - sin datos asociados",
                    $projectId
                );

                Log::info("Proyecto eliminado permanentemente por admin: {$projectName} (ID: {$projectId})");

                return redirect()->route('homeadmin')->with('success',
                    "Proyecto '{$projectName}' eliminado permanentemente. No tenía datos asociados.");
            }
            
        } catch (\Exception $e) {
            Log::error("Error al eliminar proyecto ID {$project->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar el proyecto. Por favor, inténtelo de nuevo.');
        }
    }
}
