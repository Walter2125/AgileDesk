<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\IsApproved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/login')); // Redirigir a la página de inicio de sesión

// Ruta de dashboard protegida por middleware de autenticación y aprobación
Route::middleware(['auth', IsApproved::class])->get('dashboard', function () {
        return Auth::user()->usertype === 'admin'
            ? redirect()->route('homeadmin')
            : redirect()->route('homeuser');
    })->name('dashboard');

// Rutas para usuarios autenticados
Route::middleware(['auth', IsApproved::class])->group(function () {
    Route::get('/homeuser', [UserController::class, 'index'])->name('homeuser');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
    });

require __DIR__.'/auth.php';
