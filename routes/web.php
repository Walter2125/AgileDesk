<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\IsApproved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\ColumnaController;
use App\Http\Conntroller\SprintController;
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

        // CRUD de proyectos
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth');
        Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store')->middleware('auth');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::get('/projects', [ProjectController::class, 'myprojects'])->name('projects.my')->middleware('auth');
        Route::delete('/projects/{project}/remove-user/{user}', [ProjectController::class, 'removeUser'])->name('projects.removeUser');
        Route::get('/projects/search-users', [ProjectController::class, 'searchUsers'])->name('projects.searchUsers');

        // Crud de tableros

        Route::get('/projects/{project}/tablero', [TableroController::class, 'show'])->name('tableros.show');
        Route::post('/columnas/{tablero}/store', [ColumnaController::class, 'store'])->name('columnas.store');

          // Actualizar nombre de columna (PUT)
        Route::put('/columnas/{columna}/update', [ColumnaController::class, 'update'])->name('columnas.update');

        //--------------------------------------------------

        // Corregir el nombre del método al que apunta la ruta
        Route::get('/users/list', [ProjectController::class, 'list'])->name('users.list');

        // Gestión de usuarios
        Route::get('/miembros',    [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/search',[UserController::class, 'search'])->name('users.search');


    });


require __DIR__.'/auth.php';
