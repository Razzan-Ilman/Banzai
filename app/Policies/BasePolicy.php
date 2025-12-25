<?php

namespace App\Policies;

use App\Models\User;

/**
 * Base Policy dengan common authorization methods
 */
abstract class BasePolicy
{
    /**
     * Admin dapat melakukan semua aksi
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        return null;
    }
    
    /**
     * Check if user is content owner
     */
    protected function isOwner(User $user, $model): bool
    {
        $ownerField = $model->getOwnerField ?? 'user_id';
        return $model->{$ownerField} === $user->id;
    }
    
    /**
     * Check if user is core member
     */
    protected function isCore(User $user): bool
    {
        return $user->role === 'core' || $user->role === 'admin';
    }
    
    /**
     * Check if user is member or above
     */
    protected function isMember(User $user): bool
    {
        return in_array($user->role, ['member', 'core', 'admin']);
    }
}
