<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Discussion;

class DiscussionPolicy extends BasePolicy
{
    /**
     * Member bisa lihat semua diskusi
     */
    public function viewAny(User $user): bool
    {
        return $this->isMember($user);
    }

    /**
     * Member bisa lihat detail diskusi
     */
    public function view(User $user, Discussion $discussion): bool
    {
        return $this->isMember($user);
    }

    /**
     * Member bisa buat diskusi
     */
    public function create(User $user): bool
    {
        return $this->isMember($user);
    }

    /**
     * Hanya creator yang bisa edit
     */
    public function update(User $user, Discussion $discussion): bool
    {
        return $this->isOwner($user, $discussion);
    }

    /**
     * Creator atau core bisa hapus
     */
    public function delete(User $user, Discussion $discussion): bool
    {
        return $this->isOwner($user, $discussion) || $this->isCore($user);
    }

    /**
     * Core bisa pin/unpin diskusi
     */
    public function pin(User $user, Discussion $discussion): bool
    {
        return $this->isCore($user);
    }

    /**
     * Member bisa reply ke diskusi
     */
    public function reply(User $user, Discussion $discussion): bool
    {
        return $this->isMember($user);
    }

    /**
     * Core bisa moderate (lock, move, etc)
     */
    public function moderate(User $user, Discussion $discussion): bool
    {
        return $this->isCore($user);
    }
}
