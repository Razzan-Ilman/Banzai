<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Material;

class MaterialPolicy extends BasePolicy
{
    /**
     * Semua user bisa lihat list materi
     */
    public function viewAny(User $user): bool
    {
        return $this->isMember($user);
    }

    /**
     * Member bisa lihat detail materi
     */
    public function view(User $user, Material $material): bool
    {
        return $this->isMember($user);
    }

    /**
     * Hanya core/admin yang bisa buat materi
     */
    public function create(User $user): bool
    {
        return $this->isCore($user);
    }

    /**
     * Creator atau core bisa edit
     */
    public function update(User $user, Material $material): bool
    {
        return $this->isOwner($user, $material) || $this->isCore($user);
    }

    /**
     * Hanya admin atau creator yang bisa hapus
     */
    public function delete(User $user, Material $material): bool
    {
        return $this->isOwner($user, $material);
    }
}
