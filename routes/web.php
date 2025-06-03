<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\HistoriasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\IsApproved;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\ColumnaController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\HistorialCambioController;
use App\Http\Controllers\BacklogController;
use App\Models\Project;
use App\Models\User;
use App\Models\Columna;
use App\Models\Notificaciones;
use App\Models\Tablero;



Route::get('/', fn() => redirect('/login')); // Redirigir a la página de inicio de sesión

// Ruta de dashboard protegida por middleware de autenticación y aprobación
Route::middleware(['auth', IsApproved::class])->get('dashboard', function () {
    // Comprobar si hay mensajes de error persistentes y pasarlos a la siguiente redirección
    $persistentError = Session::get('persistent_error');
    $persistentMessage = Session::get('persistent_message');

    // Determinar la ruta a la que redirigir
    $route = Auth::user()->usertype === 'admin' ? 'homeadmin' : 'homeuser';

    // Si hay mensajes persistentes, pasarlos a la siguiente redirección
    if ($persistentError) {
        return redirect()->route($route)->with([
            'error' => $persistentError,
            'message' => $persistentMessage
        ]);
    }

    return redirect()->route($route);
})->name('dashboard');
// Rutas para usuarios autenticados
Route::middleware(['auth', IsApproved::class])->group(function () {
    Route::get('/homeuser', [UserController::class, 'index'])->name('homeuser');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//Rutas para las historias

Route::get('/historias/create/columna/{columna}', [HistoriasController::class, 'createFromColumna'])->name('historias.create.fromColumna');

Route::get('/columnas/{columna}/historias/create', [HistoriasController::class, 'createFromColumna'])
    ->name('historias.create.fromColumna');
Route::get('/historias',[HistoriasController::class,'index'])->name('historias.index');
Route::get('/historias/create',[HistoriasController::class, 'create'])->name('historias.create');
Route::post('/historias/store', [HistoriasController::class, 'store'])->name('historias.store');
Route::get('/historas/{historia}/show',[HistoriasController::class,'show'])->name('historias.show');
Route::get('/historias/{historia}/edit',[HistoriasController::class,'edit'])->name('historias.edit');
Route::patch('/historias/{historia}/',[HistoriasController::class,'update'])->name('historias.update');
Route::delete('/historias/{historia}/destroy',[HistoriasController::class,'destroy'])->name('historias.destroy');



Route::middleware(['auth'])->group(function() {
    // Ruta para el listado AJAX de usuarios
    Route::get('/projects/users/list', [ProjectController::class, 'list'])->name('projects.list');
});


// Rutas solo para administradores, donde pueden ver y aprobar colaboradores
// Panel de administración — solo administradores
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/homeadmin', [AdminController::class, 'index'])->name('homeadmin');
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('admin.users.approve');
        Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('admin.users.reject');
        //historial de cambios
        Route::get('/historial', [HistorialCambioController::class, 'index'])->name('historial.index');

        // CRUD de proyectos
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth');
        Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store')->middleware('auth');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::get('/projects', [ProjectController::class, 'myprojects'])->name('projects.my')->middleware('auth');
        Route::delete('/projects/{project}/remove-user/{user}', [ProjectController::class, 'removeUser'])->name('projects.removeUser');
        Route::get('/projects/search-users', [ProjectController::class, 'searchUsers'])->name('projects.searchUsers');
        Route::get('/projects/users/list', [ProjectController::class, 'listUsers'])->name('projects.listUsers');

        // Crud de tableros

        Route::get('/projects/{project}/tablero', [TableroController::class, 'show'])->name('tableros.show');
        Route::post('/columnas/{tablero}/store', [ColumnaController::class, 'store'])->name('columnas.store');

          // Actualizar nombre de columna (PUT)
        Route::put('/columnas/{columna}/update', [ColumnaController::class, 'update'])->name('columnas.update');

        Route::put('/columnas/{columna}', [ColumnaController::class, 'update'])->name('columnas.update');


        //--------------------------------------------------

        // Crud de Sprints

        Route::get('/projects/{project}/tablero/sprints', [SprintController::class, 'index'])->name('sprints.index');


        // Crear un sprint para el proyecto
        Route::post('/projects/{project}/tablero/sprints', [SprintController::class, 'store'])->name('sprints.store');

        // Eliminar un sprint (sin necesidad de pasar por tablero)
        Route::delete('/sprints/{sprint}', [SprintController::class, 'destroy'])->name('sprints.destroy');

        //------------
        Route::get('/projects/{project}/backlog', [BacklogController::class, 'index'])->name('backlog.index');





        //------------------------------------------------------

        // Corregir el nombre del método al que apunta la ruta
        Route::get('/users/list', [ProjectController::class, 'list'])->name('users.list');

        // Gestión de usuarios
        Route::get('/miembros',    [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/search',[UserController::class, 'search'])->name('users.search');


    });

// Rutas para Tareas protegidas por autenticación y aprobación
Route::middleware(['auth', IsApproved::class])->group(function () {
Route::get('/historias/{historia}/tareas', [TareaController::class, 'index'])->name('tareas.index');
Route::post('/historias/{historia}/tareas', [TareaController::class, 'store'])->name('tareas.store');
Route::get('historias/{historia}/tareas/{tarea}/edit', [TareaController::class, 'edit'])->name('tareas.edit');
Route::put('historias/{historia}/tareas/{tarea}', [TareaController::class, 'update'])->name('tareas.update');
Route::delete('historias/{historia}/tareas/{tarea}', [TareaController::class, 'destroy'])->name('tareas.destroy');
Route::get('/historias/{historia}/tareas/lista', [TareaController::class, 'lista'])->name('tareas.show');

});

require __DIR__.'/auth.php';
