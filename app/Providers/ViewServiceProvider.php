<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Models\Historia;
use App\Models\Project;
use App\Models\Columna;
use App\Models\Tablero;
use Illuminate\Support\Facades\Log;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void 
    {
        View::composer('*', function ($view) {
            $currentRoute = Route::current();
            $route = Route::currentRouteName();
            
            // Verificar que existe una ruta actual antes de acceder a sus parámetros
            if (!$currentRoute) {
                View::share('breadcrumbs', []);
                return;
            }
            
            $historiaParam = $currentRoute->parameter('historia');
            $tablero = null;
            $historia = null;

            // Si $historia es un ID, lo buscamos como modelo con sus relaciones
            if (is_numeric($historiaParam)) {
                try {
                    $historia = Historia::with(['columna.tablero.proyecto'])->find($historiaParam);
                } catch (\Exception $e) {
                    Log::error('Error cargando historia: ' . $e->getMessage());
                }
            } elseif ($historiaParam instanceof Historia) {
                $historia = $historiaParam->load('columna.tablero.proyecto');
            }

            // Si tenemos historia cargada y su columna tiene tablero
            if ($historia && $historia->columna && $historia->columna->tablero) {
                $tablero = $historia->columna->tablero;
                View::share('historia', $historia);
                View::share('tablero', $tablero);
            }
            
            // Si estamos en la ruta del tablero directamente
            if ($route === 'tableros.show') {
                $tableroParam = $currentRoute->parameter('tablero');
                $projectParam = $currentRoute->parameter('project');
                
                if ($tableroParam instanceof Tablero) {
                    $tablero = $tableroParam->load('proyecto');
                } elseif (is_numeric($tableroParam)) {
                    try {
                        $tablero = Tablero::with('proyecto')->find($tableroParam);
                    } catch (\Exception $e) {
                        Log::error('Error cargando tablero: ' . $e->getMessage());
                    }
                } elseif ($projectParam) {
                    // Si no hay tablero pero sí proyecto, buscar por proyecto
                    $project = is_numeric($projectParam) ? Project::find($projectParam) : $projectParam;
                    if ($project) {
                        try {
                            $tablero = Tablero::with('proyecto')->where('proyecto_id', $project->id)->first();
                        } catch (\Exception $e) {
                            Log::error('Error cargando tablero por proyecto: ' . $e->getMessage());
                        }
                    }
                }

                if ($tablero) {
                    View::share('tablero', $tablero);
                }
            }

            $breadcrumbsMap = [
                // Dashboard
                'dashboard' => [
                    ['label' => 'Inicio', 'url' => route('dashboard')],
                ],

                // Home user / profile
                'profile.edit' => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Perfil',      'url' => route('profile.edit')],
                ],
                'profile.update' => 'profile.edit',
                'profile.destroy'=> 'profile.edit',

                // Historias
                'historias.index' => function() use ($tablero) {
                    return [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Historias'],
                    ];
                },
                'historias.create' => function() {
                    return [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                        ['label' => 'Historia'],
                    ];
                },

                'historias.create.fromColumna' => function () {
                    $currentRoute = Route::current();
                    
                    if (!$currentRoute) {
                        return [
                            ['label' => 'Inicio', 'url' => route('dashboard')],
                            ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                            ['label' => 'Nueva historia'],
                        ];
                    }
                    
                    $columnaParam = $currentRoute->parameter('columna');
                    $columna = null;

                    if (is_numeric($columnaParam)) {
                        try {
                            $columna = Columna::with('tablero.proyecto')->find($columnaParam);
                        } catch (\Exception $e) {
                            Log::error('Error cargando columna: ' . $e->getMessage());
                        }
                    } elseif ($columnaParam instanceof Columna) {
                        $columna = $columnaParam->load('tablero.proyecto');
                    }

                    $tablero = $columna?->tablero;

                    if (!$tablero || !$tablero->proyecto) {
                        return [
                            ['label' => 'Inicio', 'url' => route('dashboard')],
                            ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                            ['label' => 'Nueva historia'],
                        ];
                    }

                    return [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                        ['label'=> 'Tablero', 'url'=> route('tableros.show', ['project' => $tablero->proyecto->id])],
                        ['label' => 'Nueva historia'],
                    ];
                },

                'historias.store' => 'historias.index',
                'historias.show' => function() use ($tablero, $historia) {
                    $breadcrumbs = [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                    ];

                    if ($tablero && $tablero->proyecto) {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> route('tableros.show', ['project' => $tablero->proyecto->id])];
                    } else {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> '#'];
                    }

                    $breadcrumbs[] = ['label' => 'Ver historia'];
                    return $breadcrumbs;
                },
                'historias.edit' => function() use ($tablero, $historia) {
                    $breadcrumbs = [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                    ];

                    if ($tablero && $tablero->proyecto) {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> route('tableros.show', ['project' => $tablero->proyecto->id])];
                    } else {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> '#'];
                    }

                    if ($historia) {
                        $breadcrumbs[] = ['label'=>'Historia','url'=> route('historias.show',$historia->id)];
                    } else {
                        $breadcrumbs[] = ['label'=>'Historia','url'=> '#'];
                    }

                    $breadcrumbs[] = ['label' => 'Editar historia'];
                    return $breadcrumbs;
                },

                'historias.update' => 'historias.edit',
                'historias.destroy'=> 'historias.index',

                // Projects AJAX
                'projects.list' => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Proyectos AJAX'],
                ],

                // Historial de cambios
                'historial.index' => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Historial cambios'],
                ],

                // Projects CRUD
                'projects.create'  => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                    ['label' => 'Crear proyecto'],
                ],
                'projects.store'   => 'projects.create',
                'projects.my'      => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Mis proyectos'],
                ],
                'projects.edit'    => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                    ['label' => 'Editar proyecto'],
                ],
                'projects.update'  => 'projects.edit',
                'projects.destroy' => 'projects.my',
                'projects.removeUser'  => 'projects.my',
                'projects.searchUsers'=> 'projects.my',
                'projects.listUsers'  => 'projects.my',

                // Backlog
                'backlog.index' => function() {
                    $currentRoute = Route::current();
                    
                    // Verificar si la ruta existe y tiene parámetro project
                    if (!$currentRoute) {
                        return [
                            ['label' => 'Inicio', 'url' => route('dashboard')],
                            ['label' => 'Backlog']
                        ];
                    }

                    $projectParam = $currentRoute->parameter('project');
                    
                    // Si no hay proyecto, retornar breadcrumb básico
                    if (!$projectParam) {
                        return [
                            ['label' => 'Inicio', 'url' => route('dashboard')],
                            ['label' => 'Backlog']
                        ];
                    }

                    $project = null;
                    
                    // Cargar la relación tablero si no está cargada
                    if (is_numeric($projectParam)) {
                        try {
                            $project = Project::with('tablero')->find($projectParam);
                        } catch (\Exception $e) {
                            Log::error('Error cargando proyecto para backlog: ' . $e->getMessage());
                        }
                    } elseif (is_object($projectParam)) {
                        $project = $projectParam;
                        if (!$project->relationLoaded('tablero')) {
                            $project->load('tablero');
                        }
                    }

                    $breadcrumbs = [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                    ];

                    if ($project && $project->tablero) {
                        $breadcrumbs[] = ['label' => 'Tablero', 'url' => route('tableros.show', ['project' => $project->id])];
                    } else {
                        $breadcrumbs[] = ['label' => 'Tablero', 'url' => '#'];
                    }

                    $breadcrumbs[] = ['label' => 'Backlog'];
                    return $breadcrumbs;
                },
                
                // Tableros y columnas
                'tableros.show' => function() {
                    $currentRoute = Route::current();
                    
                    if (!$currentRoute) {
                        return [
                            ['label' => 'Inicio', 'url' => route('dashboard')],
                            ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                            ['label' => 'Tablero'],
                        ];
                    }

                    $projectParam = $currentRoute->parameter('project');
                    $project = null;

                    if (is_numeric($projectParam)) {
                        try {
                            $project = Project::find($projectParam);
                        } catch (\Exception $e) {
                            Log::error('Error cargando proyecto para tablero: ' . $e->getMessage());
                        }
                    } elseif (is_object($projectParam)) {
                        $project = $projectParam;
                    }

                    return [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                        ['label' => 'Tablero'],
                    ];
                },
                'columnas.store'     => 'tableros.show',
                'columnas.update'    => 'tableros.show',

                // Usuarios list
                'users.list'      => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Lista usuarios'],
                ],
                'admin.users.index'=> [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Miembros'],
                ],
                'users.search'    => 'admin.users.index',

                // Tareas
                'tareas.index' => function() use ($tablero, $historia) {
                    $breadcrumbs = [
                        ['label'=>'Inicio','url'=>route('dashboard')],
                        ['label'=>'Mis proyectos','url'=>route('projects.my')],
                    ];

                    if ($tablero && $tablero->proyecto) {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> route('tableros.show', ['project' => $tablero->proyecto->id])];
                    } else {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> '#'];
                    }

                    if ($historia) {
                        $breadcrumbs[] = ['label'=>'Historia','url'=> route('historias.show',$historia->id)];
                        $breadcrumbs[] = ['label'=>'Lista de tareas','url'=> route('tareas.show',$historia->id)];
                    } else {
                        $breadcrumbs[] = ['label'=>'Historia','url'=> '#'];
                        $breadcrumbs[] = ['label'=>'Lista de tareas','url'=> '#'];
                    }

                    $breadcrumbs[] = ['label'=>'Crear tarea'];
                    return $breadcrumbs;
                },
                'tareas.store'=> 'tareas.index',
                'tareas.edit' => function() use ($tablero, $historia) {
                    $breadcrumbs = [
                        ['label'=>'Inicio','url'=>route('dashboard')],
                        ['label'=>'Mis proyectos','url'=>route('projects.my')],
                    ];

                    if ($tablero && $tablero->proyecto) {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> route('tableros.show', ['project' => $tablero->proyecto->id])];
                    } else {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> '#'];
                    }

                    if ($historia) {
                        $breadcrumbs[] = ['label'=>'Historia','url'=> route('historias.show',$historia->id)];
                        $breadcrumbs[] = ['label'=>'Lista de tareas','url'=> route('tareas.show',$historia->id)];
                    } else {
                        $breadcrumbs[] = ['label'=>'Historia','url'=> '#'];
                        $breadcrumbs[] = ['label'=>'Lista de tareas','url'=> '#'];
                    }

                    $breadcrumbs[] = ['label'=>'Editar tarea'];
                    return $breadcrumbs;
                },
                'tareas.update'  => 'tareas.edit',
                'tareas.destroy' => 'tareas.index',
                'tareas.show' => function() use ($tablero, $historia) {
                    $breadcrumbs = [
                        ['label'=>'Inicio','url'=>route('dashboard')],
                        ['label'=>'Mis proyectos','url'=>route('projects.my')],
                    ];

                    if ($tablero && $tablero->proyecto) {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> route('tableros.show', ['project' => $tablero->proyecto->id])];
                    } else {
                        $breadcrumbs[] = ['label'=> 'Tablero', 'url'=> '#'];
                    }

                    if ($historia) {
                        $breadcrumbs[] = ['label'=>'Historia','url'=> route('historias.show',$historia->id)];
                    } else {
                        $breadcrumbs[] = ['label'=>'Historia','url'=> '#'];
                    }

                    $breadcrumbs[] = ['label'=>'Lista de tareas'];
                    return $breadcrumbs;
                },

                // Administración
                'homeadmin' => [
                    ['label' => 'Inicio', 'url' => route('dashboard')],
                    ['label' => 'Panel de Administración'],
                ],

                // Usuarios administrativos
                'admin.users' => [
                    ['label' => 'Inicio', 'url' => route('homeadmin')],
                    ['label' => 'Usuarios del Sistema'],
                ],
                'admin.users.index' => [
                    ['label' => 'Inicio', 'url' => route('homeadmin')],
                    ['label' => 'Usuarios del Sistema', 'url' => route('admin.users')],
                    ['label' => 'Usuarios Pendientes'],
                ],
                'admin.soft-deleted' => [
                    ['label' => 'Inicio', 'url' => route('homeadmin')],
                    ['label' => 'Elementos Eliminados'],
                ],

                // Sprints
                'sprints.index' => function() {
                    $currentRoute = Route::current();
                    
                    if (!$currentRoute) {
                        return [
                            ['label' => 'Inicio', 'url' => route('dashboard')],
                            ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                            ['label' => 'Sprints'],
                        ];
                    }

                    $projectParam = $currentRoute->parameter('project');
                    $project = null;

                    if (is_numeric($projectParam)) {
                        try {
                            $project = Project::find($projectParam);
                        } catch (\Exception $e) {
                            Log::error('Error cargando proyecto para sprints: ' . $e->getMessage());
                        }
                    } elseif (is_object($projectParam)) {
                        $project = $projectParam;
                    }

                    $breadcrumbs = [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                    ];

                    if ($project) {
                        $breadcrumbs[] = ['label' => 'Tablero', 'url' => route('tableros.show', ['project' => $project->id])];
                    } else {
                        $breadcrumbs[] = ['label' => 'Tablero', 'url' => '#'];
                    }

                    $breadcrumbs[] = ['label' => 'Sprints'];
                    return $breadcrumbs;
                },
                'sprints.edit' => function() {
                    $currentRoute = Route::current();
                    
                    if (!$currentRoute) {
                        return [
                            ['label' => 'Inicio', 'url' => route('dashboard')],
                            ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                            ['label' => 'Editar Sprint'],
                        ];
                    }

                    $sprintParam = $currentRoute->parameter('sprint');
                    $sprint = null;

                    if (is_numeric($sprintParam)) {
                        try {
                            $sprint = \App\Models\Sprint::with('tablero.proyecto')->find($sprintParam);
                        } catch (\Exception $e) {
                            Log::error('Error cargando sprint para edición: ' . $e->getMessage());
                        }
                    } elseif (is_object($sprintParam)) {
                        $sprint = $sprintParam;
                        if (!$sprint->relationLoaded('tablero')) {
                            $sprint->load('tablero.proyecto');
                        }
                    }

                    $breadcrumbs = [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                    ];

                    if ($sprint && $sprint->tablero && $sprint->tablero->proyecto) {
                        $project = $sprint->tablero->proyecto;
                        $breadcrumbs[] = ['label' => 'Tablero', 'url' => route('tableros.show', ['project' => $project->id])];
                        $breadcrumbs[] = ['label' => 'Sprints', 'url' => route('sprints.index', ['project' => $project->id])];
                    } else {
                        $breadcrumbs[] = ['label' => 'Tablero', 'url' => '#'];
                        $breadcrumbs[] = ['label' => 'Sprints', 'url' => '#'];
                    }

                    $breadcrumbs[] = ['label' => 'Editar Sprint'];
                    return $breadcrumbs;
                },
                'sprints.store' => 'sprints.index',
                'sprints.update' => 'sprints.edit',
                'sprints.destroy' => 'sprints.index',
            ];

            // Normalizar atajos de rutas
            foreach ($breadcrumbsMap as $key => $val) {
                if (is_string($val) && isset($breadcrumbsMap[$val])) {
                    $breadcrumbsMap[$key] = $breadcrumbsMap[$val];
                }
            }

            // Obtener las migas de pan para la ruta actual
            $breadcrumbs = $breadcrumbsMap[$route] ?? [];

            // Si es una función, evaluarla para obtener las migas de pan
            if ($breadcrumbs instanceof \Closure) {
                try {
                    $breadcrumbs = $breadcrumbs();
                } catch (\Exception $e) {
                    Log::error('Error generando breadcrumbs para ruta ' . $route . ': ' . $e->getMessage());
                    $breadcrumbs = [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Error en navegación'],
                    ];
                }
            }

            // Asegurar que breadcrumbs sea un array
            if (!is_array($breadcrumbs)) {
                $breadcrumbs = [];
            }

            // Compartir migas con la vista
            View::share('breadcrumbs', $breadcrumbs);
        });
    }
}