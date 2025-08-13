<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios del sistema
        $users = User::orderBy('created_at', 'desc')->get();
        
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
            return redirect()->back();
        }

        if ($user->is_rejected) {
            $message = 'No se puede aprobar: el usuario ya fue rechazado.';
            session()->flash('error', $message);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }
            return redirect()->back();
        }

        // Acción
        $user->is_approved = true;
        $user->is_rejected = false;
        $user->save();

        // Si es una solicitud AJAX, retornar JSON
        if ($request->expectsJson() || $request->ajax()) {
            // Flash por si luego se recarga/navega
            session()->flash('success', 'Colaborador aprobado correctamente.');
            return response()->json([
                'success' => true,
                'message' => 'Colaborador aprobado correctamente.'
            ]);
        }

        return redirect()->back()->with('success', 'Colaborador aprobado correctamente.');
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
}