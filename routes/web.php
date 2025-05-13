<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\IsApproved;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta de dashboard protegida por middleware de autenticación y aprobación
Route::middleware(['auth', IsApproved::class])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas solo para administradores, donde pueden ver y aprobar colaboradores
// Panel de administración — solo administradores
Route::middleware(['auth', 'role'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('admin.users.approve');
        Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('admin.users.reject');
    });

// Rutas para Tareas protegidas por autenticación y aprobación
Route::middleware(['auth', IsApproved::class])->group(function () {
    Route::get('/tareas', [TareaController::class, 'index'])->name('tareas.index');
    Route::post('/tareas', [TareaController::class, 'store'])->name('tareas.store');
});

require __DIR__.'/auth.php';
