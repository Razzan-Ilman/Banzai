<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy extends BasePolicy
{
    /**
     * Semua bisa lihat list event
     */
    public function viewAny(?User $user): bool
    {
        return true; // Public
    }

    /**
     * Semua bisa lihat detail event
     */
    public function view(?User $user, Event $event): bool
    {
        return true; // Public
    }

    /**
     * Hanya core yang bisa buat event
     */
    public function create(User $user): bool
    {
        return $this->isCore($user);
    }

    /**
     * Core bisa edit event
     */
    public function update(User $user, Event $event): bool
    {
        return $this->isCore($user);
    }

    /**
     * Hanya admin yang bisa hapus event
     */
    public function delete(User $user, Event $event): bool
    {
        return false; // Only admin via before()
    }

    /**
     * Member bisa register ke event
     */
    public function register(User $user, Event $event): bool
    {
        if (!$this->isMember($user)) return false;
        if ($event->registration_deadline && now()->isAfter($event->registration_deadline)) return false;
        if ($event->isFull()) return false;
        
        return true;
    }

    /**
     * User bisa cancel registration sendiri
     */
    public function cancelRegistration(User $user, Event $event): bool
    {
        return $this->isMember($user);
    }

    /**
     * Core bisa manage registrations
     */
    public function manageRegistrations(User $user, Event $event): bool
    {
        return $this->isCore($user);
    }
}
