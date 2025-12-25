<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Gallery;

class GalleryPolicy extends BasePolicy
{
    /**
     * Semua bisa lihat gallery yang published
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Public bisa lihat gallery yang published
     */
    public function view(?User $user, Gallery $gallery): bool
    {
        if ($gallery->is_published) return true;
        return $user && $this->isCore($user);
    }

    /**
     * Core bisa buat gallery
     */
    public function create(User $user): bool
    {
        return $this->isCore($user);
    }

    /**
     * Core bisa edit gallery
     */
    public function update(User $user, Gallery $gallery): bool
    {
        return $this->isCore($user);
    }

    /**
     * Hanya admin yang bisa hapus
     */
    public function delete(User $user, Gallery $gallery): bool
    {
        return false; // Only admin via before()
    }

    /**
     * Core bisa upload foto ke gallery
     */
    public function uploadPhoto(User $user, Gallery $gallery): bool
    {
        return $this->isCore($user);
    }
}
