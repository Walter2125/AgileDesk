<?php

namespace App\Policies;

use App\Models\User;

class SoftDeletePolicy
{
    /**
     * Determinar si el usuario puede ver elementos soft-deleted
     */
    public function viewAny(User $user): bool
    {
        return $user->usertype === 'admin';
    }

    /**
     * Determinar si el usuario puede restaurar elementos
     */
    public function restore(User $user): bool
    {
        return $user->usertype === 'admin';
    }

    /**
     * Determinar si el usuario puede eliminar permanentemente elementos
     */
    public function forceDelete(User $user): bool
    {
        return $user->usertype === 'admin';
    }
}
