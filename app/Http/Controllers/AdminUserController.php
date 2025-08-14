<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        
        // Filtrar usuarios según el rol del que está viendo
        if ($currentUser->isSuperAdmin()) {
            // Superadmin puede ver todos los usuarios
            $users = User::orderBy('created_at', 'desc')->get();
            Log::info('Superadmin accedió a vista de todos los usuarios', ['superadmin_id' => $currentUser->id]);
        } else {
            // Administradores solo pueden ver colaboradores y otros administradores (no superadmins)
            $users = User::whereIn('usertype', ['admin', 'collaborator'])
                ->orderBy('created_at', 'desc')
                ->get();
            Log::info('Administrador accedió a vista de usuarios limitada', ['admin_id' => $currentUser->id]);
        }
        
        // También obtener usuarios pendientes para otras funcionalidades si es necesario
        $pendingUsers = User::where('usertype', 'collaborator')
            ->where('is_approved', false)
            ->where('is_rejected', false)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('users.admin.users', compact('users', 'pendingUsers'));
    }
    
    public function pendingUsers()
    {
        // Obtener solo usuarios pendientes para la vista index
        $pendingUsers = User::where('usertype', 'collaborator')
            ->where('is_approved', false)
            ->where('is_rejected', false)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('users.admin.index', compact('pendingUsers'));
    }
    
    public function approve(User $user, Request $request)
    {
        // Validaciones previas
        if ($user->is_approved) {
            $message = 'El usuario ya ha sido aprobado.';
            // Flash para vistas tradicionales
            session()->flash('error', $message);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }
            return redirect()->route('admin.users.index')->with('error', $message);
        }

        if ($user->is_rejected) {
            $message = 'El usuario está rechazado. No se puede aprobar.';
            session()->flash('error', $message);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }
            return redirect()->route('admin.users.index')->with('error', $message);
        }

        // Validar y procesar asignación de rol
        $currentUser = Auth::user();
        $assignedRole = 'collaborator'; // Rol por defecto

        if ($currentUser->isSuperAdmin()) {
            // Solo el superadmin puede asignar roles diferentes
            $request->validate([
                'role' => ['required', 'in:collaborator,admin,superadmin']
            ]);
            
            $requestedRole = $request->input('role');
            
            // Verificar si se intenta asignar superadmin
            if ($requestedRole === 'superadmin') {
                // Verificar que solo el superadmin actual pueda asignar este rol
                if ($user->id === $currentUser->id) {
                    $assignedRole = 'superadmin';
                } else {
                    // Permitir asignar superadmin a otros usuarios si el actual está de acuerdo
                    $assignedRole = 'superadmin';
                    
                    // Log de cambio importante
                    Log::warning("Nuevo superadministrador asignado", [
                        'current_superadmin_id' => $currentUser->id,
                        'current_superadmin_name' => $currentUser->name,
                        'new_superadmin_id' => $user->id,
                        'new_superadmin_name' => $user->name,
                        'timestamp' => now()
                    ]);
                }
            } else {
                $assignedRole = $requestedRole;
            }
        } else {
            // Admin normal solo puede aprobar como colaborador
            $assignedRole = 'collaborator';
        }

        // Actualizar usuario
        $user->is_approved = true;
        $user->is_rejected = false;
        $user->usertype = $assignedRole;
        $user->save();

        // Registrar en el historial del sistema
        \App\Models\HistorialCambio::create([
            'fecha' => now(),
            'usuario' => $currentUser->name,
            'accion' => 'Aprobación de usuario',
            'detalles' => "Usuario '{$user->name}' aprobado como " . match($assignedRole) {
                'superadmin' => 'Superadministrador',
                'admin' => 'Administrador',
                'collaborator' => 'Colaborador',
                default => ucfirst($assignedRole)
            },
            'sprint' => null,
            'proyecto_id' => null
        ]);

        $message = "Usuario aprobado correctamente como " . match($assignedRole) {
            'superadmin' => 'Superadministrador',
            'admin' => 'Administrador',
            'collaborator' => 'Colaborador',
            default => ucfirst($assignedRole)
        } . ".";

        // Log del cambio
        Log::info("Usuario aprobado", [
            'approved_by_id' => $currentUser->id,
            'approved_by_name' => $currentUser->name,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'assigned_role' => $assignedRole
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->usertype,
                    'is_approved' => $user->is_approved
                ]
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    public function reject(User $user, Request $request)
    {
        if (!$user) {
            // Si es una solicitud AJAX, retornar JSON de error
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado.'
                ], 404);
            }
            
            return redirect()->route('admin.users')->with('error', 'Usuario no encontrado.');
        }

        // Verifica si el usuario ya está rechazado
        if ($user->is_rejected) {
            // Si es una solicitud AJAX, retornar JSON de error
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El usuario ya ha sido rechazado.'
                ], 400);
            }
            
            return redirect()->route('admin.users')->with('error', 'El usuario ya ha sido rechazado.');
        }

        // Si ya está aprobado, no permitir rechazar
        if ($user->is_approved) {
            $message = 'No se puede rechazar: el usuario ya fue aprobado.';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }
            return redirect()->route('admin.users')->with('error', $message);
        }

        $user->is_rejected = true;
        $user->save();

        // Registrar en el historial del sistema
        \App\Models\HistorialCambio::create([
            'fecha' => now(),
            'usuario' => Auth::user()->name,
            'accion' => 'Rechazo de usuario',
            'detalles' => "Usuario '{$user->name}' ({$user->email}) rechazado",
            'sprint' => null,
            'proyecto_id' => null
        ]);

        // Si es una solicitud AJAX, retornar JSON
        if ($request->expectsJson() || $request->ajax()) {
            // Flash por si luego se recarga/navega
            session()->flash('success', 'Usuario rechazado correctamente.');
            return response()->json([
                'success' => true,
                'message' => 'Usuario rechazado correctamente.'
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Usuario rechazado correctamente.');
    }

    /**
     * Asignar rol a un usuario (solo superadmin)
     */
    public function assignRole(User $user, Request $request)
    {
        // Verificar que el usuario actual es superadmin
        if (!Auth::user()->isSuperAdmin()) {
            $message = 'Solo el superadministrador puede asignar roles.';
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 403);
            }
            
            return redirect()->back()->with('error', $message);
        }

        // Validar el rol enviado
        $request->validate([
            'role' => ['required', 'in:superadmin,admin,collaborator']
        ]);

        $newRole = $request->input('role');
        $oldRole = $user->usertype;

        // Prevenir que se asigne el rol de superadmin a otros usuarios
        // (solo puede haber un superadmin)
        if ($newRole === 'superadmin' && $user->id !== Auth::user()->id) {
            $message = 'Solo puede existir un superadministrador en el sistema.';
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }
            
            return redirect()->back()->with('error', $message);
        }

        // Actualizar el rol
        $user->usertype = $newRole;
        
        // Si se asigna admin o superadmin, aprobar automáticamente
        if (in_array($newRole, ['admin', 'superadmin'])) {
            $user->is_approved = true;
            $user->is_rejected = false;
        }
        
        $user->save();

        // Registrar en el historial del sistema
        \App\Models\HistorialCambio::create([
            'fecha' => now(),
            'usuario' => Auth::user()->name,
            'accion' => 'Cambio de rol',
            'detalles' => "Usuario '{$user->name}' cambió de rol de '{$oldRole}' a '{$newRole}'",
            'sprint' => null,
            'proyecto_id' => null
        ]);

        $message = "Rol actualizado de '{$oldRole}' a '{$newRole}' correctamente.";

        // Log del cambio
        Log::info("Rol de usuario actualizado", [
            'admin_id' => Auth::user()->id,
            'admin_name' => Auth::user()->name,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'old_role' => $oldRole,
            'new_role' => $newRole
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->usertype,
                    'is_approved' => $user->is_approved
                ]
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}