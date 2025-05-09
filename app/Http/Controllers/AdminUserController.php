<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('usertype', 'collaborator')
            ->where('is_approved', false)
            ->where('is_rejected', false)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('users.admin.index', compact('pendingUsers'));
    }
    
    public function approve(User $user)
    {
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'Colaborador aprobado correctamente.');
    }


    public function reject(User $user)
    {
        if (!$user) {
            return redirect()->route('admin.users')->with('error', 'Usuario no encontrado.');
        }

        // Verifica si el usuario ya está rechazado
        if ($user->is_rejected) {
            return redirect()->route('admin.users')->with('error', 'El usuario ya ha sido rechazado.');
        }

        $user->is_rejected = true;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Usuario rechazado correctamente.');
    }
}