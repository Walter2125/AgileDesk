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
use App\Http\Controllers\ComentarioController;

// Redirigir a la página de inicio de sesión
Route::get('/', fn() => redirect('/login'));

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

// Rutas para el backlog (accesibles para todos los usuarios autenticados y aprobados)
Route::middleware(['auth', IsApproved::class])->group(function () {
    Route::get('/projects/{project}/backlog', [BacklogController::class, 'index'])->name('backlog.index');
    Route::get('/projects/{project}/backlog/export-pdf', [BacklogController::class, 'exportPdf'])->name('backlog.export-pdf');
});

// Rutas solo para administradores
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        // Panel de administración
        Route::get('/homeadmin', [AdminController::class, 'index'])->name('homeadmin');
        
        // Gestión de usuarios
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('admin.users.approve');
        Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('admin.users.reject');
        Route::delete('/users/{user}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::patch('/users/{id}/restore', [AdminController::class, 'restoreUser'])->name('admin.users.restore');
        Route::get('/deleted-users', [AdminController::class, 'deletedUsers'])->name('admin.deleted-users');
        Route::delete('/users/{id}/permanent-delete', [AdminController::class, 'permanentDeleteUser'])->name('admin.users.permanent-delete');
        Route::get('/miembros', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
        Route::get('/users/list', [ProjectController::class, 'list'])->name('users.list');
        
        // Historial de cambios
        Route::get('/historial', [HistorialCambioController::class, 'index'])->name('historial.index');
        
        // Sprints (solo admin)
        Route::get('/projects/{project}/tablero/sprints', [SprintController::class, 'index'])->name('sprints.index');
        Route::post('/projects/{project}/tablero/sprints', [SprintController::class, 'store'])->name('sprints.store');
        Route::delete('/sprints/{sprint}', [SprintController::class, 'destroy'])->name('sprints.destroy');

         // Columnas
        Route::post('/columnas/{tablero}/store', [ColumnaController::class, 'store'])->name('columnas.store');
        Route::put('/columnas/{columna}/update', [ColumnaController::class, 'update'])->name('columnas.update');
        Route::put('/columnas/{columna}', [ColumnaController::class, 'update']);
        Route::delete('/columnas/{columna}', [ColumnaController::class, 'destroy'])->name('columnas.destroy');
        
    });

// Rutas para usuarios autenticados y aprobados
Route::middleware(['auth', IsApproved::class])->group(function () {
    // Dashboard y perfil de usuario
    Route::get('/homeuser', [UserController::class, 'index'])->name('homeuser');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Proyectos
    Route::get('/projects', [ProjectController::class, 'myprojects'])->name('projects.my');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::delete('/projects/{project}/remove-user/{user}', [ProjectController::class, 'removeUser'])->name('projects.removeUser');
    Route::get('/projects/search-users', [ProjectController::class, 'searchUsers'])->name('projects.searchUsers');
    Route::get('/projects/users/list', [ProjectController::class, 'listUsers'])->name('projects.listUsers');
    
    // Tableros
    Route::get('/projects/{project}/tablero', [TableroController::class, 'show'])->name('tableros.show');
    
    // Historias
    Route::get('/historias', [HistoriasController::class, 'index'])->name('historias.index');
    Route::get('/historias/create', [HistoriasController::class, 'create'])->name('historias.create');
    Route::post('/historias/store', [HistoriasController::class, 'store'])->name('historias.store');
    Route::get('/historias/{historia}/show', [HistoriasController::class, 'show'])->name('historias.show');
    Route::get('/historias/{historia}/edit', [HistoriasController::class, 'edit'])->name('historias.edit');
    Route::patch('/historias/{historia}', [HistoriasController::class, 'update'])->name('historias.update');
    Route::delete('/historias/{historia}/destroy', [HistoriasController::class, 'destroy'])->name('historias.destroy');
    Route::post('/historias/{id}/mover', [HistoriasController::class, 'mover'])->name('historias.mover');
    Route::get('/historias/create/columna/{columna}', [HistoriasController::class, 'createFromColumna'])->name('historias.create.fromColumna');
    Route::get('/columnas/{columna}/historias/create', [HistoriasController::class, 'createFromColumna'])->name('historias.create.fromColumna');
    
    // Tareas
    Route::get('/historias/{historia}/tareas', [TareaController::class, 'index'])->name('tareas.index');
    Route::post('/historias/{historia}/tareas', [TareaController::class, 'store'])->name('tareas.store');
    Route::get('/historias/{historia}/tareas/{tarea}/edit', [TareaController::class, 'edit'])->name('tareas.edit');
    Route::put('/historias/{historia}/tareas/{tarea}', [TareaController::class, 'update'])->name('tareas.update');
    Route::delete('/historias/{historia}/tareas/{tarea}', [TareaController::class, 'destroy'])->name('tareas.destroy');
    Route::get('/historias/{historia}/tareas/lista', [TareaController::class, 'lista'])->name('tareas.show');
    Route::post('/tareas/{tarea}/completar', [TareaController::class, 'toggleCompletada'])->name('tareas.toggleCompletada');
    
    // Comentarios
    Route::prefix('comentarios')->name('comentarios.')->group(function () {
        Route::post('/{historia}', [ComentarioController::class, 'store'])->name('store');
        Route::put('/{comentario}', [ComentarioController::class, 'update'])->name('update');
        Route::delete('/{comentario}', [ComentarioController::class, 'destroy'])->name('destroy'); 
    });
});

// Rutas de autenticación
require __DIR__.'/auth.php';
