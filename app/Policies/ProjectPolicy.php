<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados pueden ver los proyectos
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        // Todos los usuarios pueden ver los proyectos
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo admins y superadmins pueden crear proyectos
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        // Superadmin puede editar cualquier proyecto, admin solo sus propios proyectos
        return $user->isSuperAdmin() || 
               ($user->isAdmin() && $user->id === $project->user_id);
    }

    /**
     * Determine whether the user can delete the model.
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        // Superadmin puede eliminar cualquier proyecto, admin solo sus propios proyectos
        return $user->isSuperAdmin() || 
               ($user->isAdmin() && $user->id === $project->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        // Solo superadmin puede restaurar proyectos
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        // Solo superadmin puede eliminar permanentemente
        return $user->isSuperAdmin();
    }
}
