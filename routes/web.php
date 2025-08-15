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

    // Determinar la ruta a la que redirigir según el nuevo sistema de roles
    $route = match(Auth::user()->usertype) {
        'superadmin', 'admin' => 'homeadmin',
        'collaborator' => 'homeuser',
        default => 'homeuser'
    };

    // Si hay mensajes persistentes, pasarlos a la siguiente redirección
    if ($persistentError) {
        return redirect()->route($route)->with([
            'error' => $persistentError,
            'message' => $persistentMessage
        ]);
    }

    return redirect()->route($route);
})->name('dashboard');

Route::post('/historias/{id}/mover', [HistoriasController::class, 'mover'])->name('historias.mover');

// Rutas para usuarios autenticados y aprobados
Route::middleware(['auth', IsApproved::class])->group(function () {
    Route::get('/homeuser', [UserController::class, 'index'])->name('homeuser');
    Route::get('/homeuser/project/{projectId}', [UserController::class, 'index'])->name('homeuser.project');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/projects', [ProjectController::class, 'myprojects'])->name('projects.my');

    // Crud de tableros
    Route::get('/projects/{project}/tablero', [TableroController::class, 'show'])->name('tableros.show');

    // Operaciones de columnas
    Route::post('/columnas/{tablero}/store', [ColumnaController::class, 'store'])->name('columnas.store');
    Route::put('columnas/{columna}/update', [ColumnaController::class, 'update'])->name('columnas.update');
    Route::put('/columnas/{id}', [ColumnaController::class, 'update'])->name('columnas.update');
    Route::put('columnas/{columna}', [ColumnaController::class, 'update'])->name('columnas.update');
    // Perritos: La ruta para eliminar columnas se encuentra en el grupo de administradores

    // Rutas de historias relacionadas con columnas
    Route::get('/historias/create/columna/{columna}', [HistoriasController::class, 'createFromColumna'])->name('historias.create.fromColumna');
    Route::get('/columnas/{columna}/historias/create', [HistoriasController::class, 'createFromColumna'])->name('historias.create.fromColumna');

    //Rutas para las historias
    Route::get('/historias',[HistoriasController::class,'index'])->name('historias.index');
   // Route::get('/historias/create',[HistoriasController::class, 'create'])->name('historias.create');
    Route::get('/historias/create/fromColumna/{columna}', [HistoriasController::class, 'createFromColumna'])
     ->name('historias.create.fromColumna');
    Route::post('/historias/store', [HistoriasController::class, 'store'])->name('historias.store');
    Route::get('/historas/{historia}/show',[HistoriasController::class,'show'])->name('historias.show');
    Route::get('/historias/{historia}/edit',[HistoriasController::class,'edit'])->name('historias.edit');
    Route::patch('/historias/{historia}/',[HistoriasController::class,'update'])->name('historias.update');
    Route::delete('/historias/{historia}/destroy',[HistoriasController::class,'destroy'])->name('historias.destroy');

    //Rutas para Tareas
    Route::get('/historias/{historia}/tareas', [TareaController::class, 'index'])->name('tareas.index');
    Route::post('/historias/{historia}/tareas', [TareaController::class, 'store'])->name('tareas.store');
    Route::get('historias/{historia}/tareas/{tarea}/edit', [TareaController::class, 'edit'])->name('tareas.edit');
    Route::put('historias/{historia}/tareas/{tarea}', [TareaController::class, 'update'])->name('tareas.update');
    Route::delete('historias/{historia}/tareas/{tarea}', [TareaController::class, 'destroy'])->name('tareas.destroy');
    Route::get('/historias/{historia}/tareas/lista', [TareaController::class, 'lista'])->name('tareas.show');
    Route::post('/tareas/{tarea}/completar', [TareaController::class, 'toggleCompletada'])->name('tareas.toggleCompletada');
    Route::get('/historias/{historia}/detalle', [HistoriasController::class, 'showDetalle'])->name('historias.detalle');

    ////*/**/**/
    Route::get('/historias/create', [HistoriasController::class, 'create'])->name('historias.create');
    /// /*/*/*


    // Ruta para el listado AJAX de usuarios
    Route::get('/projects/users/list', [ProjectController::class, 'list'])->name('projects.list');

    //Backlog
        Route::get('/projects/{project}/backlog', [BacklogController::class, 'index'])->name('backlog.index');
        Route::get('/projects/{project}/backlog/export-pdf', [BacklogController::class, 'exportPdf'])->name('backlog.export-pdf');

    //Rutas para comentarios
    Route::prefix('comentarios')->name('comentarios.')->group(function () {
        Route::post('/{historia}', [ComentarioController::class, 'store'])->name('store');
        Route::put('/{comentario}', [ComentarioController::class, 'update'])->name('update');
        Route::delete('/{comentario}', [ComentarioController::class, 'destroy'])->name('destroy');
    });
    // Historial por proyecto (para usuarios)
    Route::get('/colaboradores/proyectos/{project}/historial',
        [HistorialCambioController::class, 'porProyecto'])
        ->name('users.colaboradores.historial')
        ->where('project', '[0-9]+');

    // Ruta correcta para cambiar el color
    Route::put('/projects/{id}/cambiar-color', [ProjectController::class, 'cambiarColor'])->name('projects.cambiarColor');
    Route::post('/projects/{project}/color', [ProjectController::class, 'cambiarColor'])->name('projects.cambiarColor');

});

// Panel de administración — superadmin y admin
Route::middleware(['auth', 'role:superadmin,admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/homeadmin', [AdminController::class, 'index'])->name('homeadmin');
        Route::get('/homeadmin/project/{projectId}', [AdminController::class, 'index'])->name('homeadmin.project');

        // Vista general de elementos soft-deleted (para ambos roles, pero con restricciones)
        Route::get('/soft-deleted', [AdminController::class, 'softDeletedItems'])->name('admin.soft-deleted');
        Route::post('/soft-deleted/restore/{model}/{id}', [AdminController::class, 'restoreItem'])->name('admin.soft-deleted.restore');
        Route::delete('/soft-deleted/permanent-delete/{model}/{id}', [AdminController::class, 'permanentDeleteItem'])->name('admin.soft-deleted.permanent-delete');

        //historial de cambios
        Route::get('/historial', [HistorialCambioController::class, 'index'])->name('historial.index');

        // CRUD de proyectos (para admins solo sus proyectos, para superadmin todos)
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}/remove-user/{user}', [ProjectController::class, 'removeUser'])->name('projects.removeUser');
        Route::get('/projects/search-users', [ProjectController::class, 'searchUsers'])->name('projects.searchUsers');
        Route::get('/projects/users/list', [ProjectController::class, 'listUsers'])->name('projects.listUsers');
        Route::put('/projects/{id}/cambiar-color', [ProjectController::class, 'cambiarColor'])->name('projects.cambiarColor');
        Route::post('/projects/{project}/color', [ProjectController::class, 'cambiarColor'])->name('projects.cambiarColor');

        // Rutas adicionales para administración de proyectos desde homeadmin
        Route::delete('/projects/{project}/admin-delete', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');

        // Crud de Sprints
        Route::get('/projects/{project}/tablero/sprints', [SprintController::class, 'index'])->name('sprints.index');
        Route::post('/projects/{project}/tablero/sprints', [SprintController::class, 'store'])->name('sprints.store');
        Route::get('/sprints/{sprint}/edit', [SprintController::class, 'edit'])->name('sprints.edit');
        Route::put('/sprints/{sprint}', [SprintController::class, 'update'])->name('sprints.update');
        Route::delete('/sprints/{sprint}', [SprintController::class, 'destroy'])->name('sprints.destroy');

        // Corregir el nombre del método al que apunta la ruta
        Route::get('/users/list', [ProjectController::class, 'list'])->name('users.list');

    // (Eliminado) Ruta de usuarios pendientes '/miembros' sustituida por vista principal users
        Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('admin.users.approve');
        Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('admin.users.reject');
        Route::get('/users/search',[UserController::class, 'search'])->name('users.search');

        // Vista de usuarios para administradores (con permisos limitados)
        Route::get('/users/manage', [AdminUserController::class, 'index'])->name('admin.users.manage');

        // Operaciones exclusivas de administradores para columnas
        Route::delete('columnas/{columna}', [ColumnaController::class, 'destroy'])->name('columnas.destroy');

        // Historial por proyecto (para administradores)
        Route::get('/users/admin/{project}/historial',
        [HistorialCambioController::class, 'porProyecto'])
            ->name('users.admin.historial')
            ->where('project', '[0-9]+');

        // Rutas para eliminar y restaurar usuarios (solo admin sobre sus proyectos)
        Route::delete('/users/{user}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::patch('/users/{id}/restore', [AdminController::class, 'restoreUser'])->name('admin.users.restore');
        Route::delete('/users/{id}/permanent-delete', [AdminController::class, 'permanentDeleteUser'])->name('admin.users.permanent-delete');
});

// Rutas exclusivas del Superadministrador
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->group(function () {
        // Vista de todos los usuarios del sistema
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');

        // Asignación de roles (solo superadmin)
        Route::post('/users/{user}/assign-role', [AdminUserController::class, 'assignRole'])->name('admin.users.assign-role');
        Route::patch('/users/{user}/role', [AdminUserController::class, 'assignRole'])->name('admin.users.update-role');

        // Acceso total a gestión de usuarios
        Route::delete('/users/{user}/force-delete', [AdminController::class, 'forceDeleteUser'])->name('admin.users.force-delete');

        // Historial completo del sistema
        Route::get('/historial-sistema', [HistorialCambioController::class, 'sistema'])->name('historial.sistema');
        Route::delete('/historial-sistema/limpiar', [HistorialCambioController::class, 'limpiarHistorial'])->name('historial.limpiar');

        Route::get('/historias/{historia}/tareas/lista', [TareaController::class, 'lista'])->name('tareas.show');
    });

// Rutas de autenticación
require __DIR__.'/auth.php';
