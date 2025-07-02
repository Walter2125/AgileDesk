<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprint;
use App\Models\HistorialCambio;
use App\Models\Project;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Solo mostrar usuarios activos (sin soft deletes)
        $usuarios = User::where('usertype', '!=', 'admin')->paginate(5, ['*'], 'usuarios_page');
        $proyectos = Project::with('creator', 'users')->paginate(5, ['*'], 'proyectos_page');
        $historial = HistorialCambio::paginate(5, ['*'], 'historial_page');
        $sprints = Sprint::with('proyecto')->paginate(5, ['*'], 'sprints_page');


        return view('users.admin.homeadmin', compact('usuarios', 'proyectos', 'historial', 'sprints'));
    }
    
    /**
     * Soft delete a user
     */
    public function deleteUser(User $user)
    {
        // Verificar que no sea un admin
        if ($user->usertype === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin users.');
        }
        
        $user->delete();
        
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    
    /**
     * Restore a soft deleted user
     */
    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        // Verificar que el usuario esté soft deleted
        if (!$user->trashed()) {
            return redirect()->back()->with('error', 'El usuario no está eliminado.');
        }
        
        // Verificar que no sea un admin
        if ($user->usertype === 'admin') {
            return redirect()->back()->with('error', 'No se pueden restaurar usuarios admin.');
        }
        
        $userName = $user->name;
        $user->restore();
        
        return redirect()->back()->with('success', "Usuario {$userName} restaurado exitosamente.");
    }
    
    /**
     * Get only active users (not soft deleted)
     */
    public function getActiveUsers()
    {
        return User::where('usertype', '!=', 'admin')->paginate(10);
    }
    
    /**
     * Get only soft deleted users
     */
    public function getDeletedUsers()
    {
        return User::onlyTrashed()->where('usertype', '!=', 'admin')->paginate(10);
    }
    
    /**
     * Show deleted users history
     */
    public function deletedUsers()
    {
        $deletedUsers = User::onlyTrashed()
            ->where('usertype', '!=', 'admin')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
            
        return view('users.admin.deleted-users', compact('deletedUsers'));
    }
    
    /**
     * Permanently delete a user
     */
    public function permanentDeleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        // Verificar que el usuario esté soft deleted
        if (!$user->trashed()) {
            return redirect()->back()->with('error', 'User is not deleted.');
        }
        
        // Verificar que no sea un admin
        if ($user->usertype === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin users.');
        }
        
        $userName = $user->name;
        $user->forceDelete();
        
        return redirect()->back()->with('success', 'User permanently deleted successfully.');
    }
}
