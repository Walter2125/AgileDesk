<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Models\Historia;

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
            $route = Route::currentRouteName();
            $historiaParam = Route::current()->parameter('historia');
            $tablero = null;
            $historia = null;

            // Si $historia es un ID, lo buscamos como modelo con sus relaciones
            if (is_numeric($historiaParam)) {
                $historia = Historia::with('columna.tablero')->find($historiaParam);
            } elseif ($historiaParam instanceof Historia) {
                $historia = $historiaParam->load('columna.tablero');
            }

            // Si tenemos historia cargada y su columna tiene tablero
            if ($historia && $historia->columna && $historia->columna->tablero) {
                $tablero = $historia->columna->tablero;
                View::share('historia', $historia);
                View::share('tablero', $tablero);
            }

            // Si estamos en la ruta del tablero directamente
            if ($route === 'tableros.show') {
                $tableroParam = Route::current()->parameter('tablero');
                if ($tableroParam instanceof \App\Models\Tablero) {
                    $tablero = $tableroParam;
                } elseif (is_numeric($tableroParam)) {
                    $tablero = \App\Models\Tablero::with('proyecto')->find($tableroParam);
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
                'homeuser' => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Mi tablero',  'url' => route('homeuser')],
                ],
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
                    $columnaParam = Route::current()->parameter('columna');
                    $columna = null;

                    if (is_numeric($columnaParam)) {
                        $columna = \App\Models\Columna::with('tablero.proyecto')->find($columnaParam);
                    } elseif ($columnaParam instanceof \App\Models\Columna) {
                        $columna = $columnaParam->load('tablero.proyecto');
                    }

                    $tablero = $columna?->tablero;

                    return [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                        ['label'=> 'Tablero', 'url'=> $tablero ? route('tableros.show', ['project' => $tablero->proyecto_id]) : '#'],
                        ['label' => 'Nueva historia'],
                    ];
                },
                'historias.store' => 'historias.index',
                'historias.show' => function() use ($tablero, $historia) {
                    return [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                        ['label'=> 'Tablero', 'url'=> $tablero ? route('tableros.show', ['project' => $tablero->proyecto_id]) : '#'],
                        ['label' => 'Ver historia'],
                    ];
                },
                'historias.edit' => function() use ($tablero, $historia) {
                    return [
                        ['label' => 'Inicio', 'url' => route('dashboard')],
                        ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                        ['label'=> 'Tablero', 'url'=> $tablero ? route('tableros.show', ['project' => $tablero->proyecto_id]) : '#'],
                        ['label'=>'Historias','url'=> $historia ? route('historias.show',$historia->id) : '#'],
                        ['label' => 'Editar historia'],
                    ];
                },
                'historias.update' => 'historias.edit',
                'historias.destroy'=> 'historias.index',

                // Projects AJAX
                'projects.list' => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Proyectos AJAX'],
                ],

                // Admin routes
                'homeadmin' => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Admin',       'url' => route('homeadmin')],
                ],
                'admin.users' => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Usuarios'],
                ],
                'admin.users.approve' => 'admin.users',
                'admin.users.reject'  => 'admin.users',
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

                // Tableros y columnas
                'tableros.show'     => [
                    ['label' => 'Inicio',      'url' => route('dashboard')],
                    ['label' => 'Mis proyectos', 'url' => route('projects.my')],
                    ['label' => 'Tablero'],
                ],
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
                    return [
                        ['label'=>'Inicio','url'=>route('dashboard')],
                        ['label'=>'Mis proyectos','url'=>route('projects.my')],
                        ['label'=> 'Tablero', 'url'=> $tablero ? route('tableros.show', ['project' => $tablero->proyecto_id]) : '#'],
                        ['label'=>'Historias','url'=> $historia ? route('historias.show',$historia->id) : '#'],
                        ['label'=>'Lista de tareas','url'=> $historia ? route('tareas.show',$historia->id) : '#'],
                        ['label'=>'Crear tarea'],
                    ];
                },
                'tareas.store'   => 'tareas.index',
                'tareas.edit' => function() use ($tablero, $historia) {
                    return [
                        ['label'=>'Inicio','url'=>route('dashboard')],
                        ['label'=>'Mis proyectos','url'=>route('projects.my')],
                        ['label'=> 'Tablero', 'url'=> $tablero ? route('tableros.show', ['project' => $tablero->proyecto_id]) : '#'],
                        ['label'=>'Historias','url'=> $historia ? route('historias.show',$historia->id) : '#'],
                        ['label'=>'Lista de tareas','url'=> $historia ? route('tareas.show',$historia->id) : '#'],
                        ['label'=>'Editar tarea'],
                    ];
                },
                'tareas.update'  => 'tareas.edit',
                'tareas.destroy' => 'tareas.index',
                'tareas.show' => function() use ($tablero, $historia) {
                    return [
                        ['label'=>'Inicio','url'=>route('dashboard')],
                        ['label'=>'Mis proyectos','url'=>route('projects.my')],
                        ['label'=> 'Tablero', 'url'=> $tablero ? route('tableros.show', ['project' => $tablero->proyecto_id]) : '#'],
                        ['label'=>'Historias','url'=> $historia ? route('historias.show',$historia->id) : '#'],
                        ['label'=>'Lista de tareas'],
                    ];
                },
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
                $breadcrumbs = $breadcrumbs();
            }

            // Compartir migas con la vista
            View::share('breadcrumbs', $breadcrumbs);
        });
    }
}
