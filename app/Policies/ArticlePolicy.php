<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;

class ArticlePolicy extends BasePolicy
{
    /**
     * Semua bisa lihat published articles
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Public bisa lihat published articles
     */
    public function view(?User $user, Article $article): bool
    {
        if ($article->status === 'published') return true;
        return $user && ($this->isOwner($user, $article) || $this->isCore($user));
    }

    /**
     * Core bisa buat artikel
     */
    public function create(User $user): bool
    {
        return $this->isCore($user);
    }

    /**
     * Author atau core bisa edit
     */
    public function update(User $user, Article $article): bool
    {
        return $this->isOwner($user, $article) || $this->isCore($user);
    }

    /**
     * Hanya admin yang bisa hapus
     */
    public function delete(User $user, Article $article): bool
    {
        return false; // Only admin via before()
    }

    /**
     * Core bisa publish artikel
     */
    public function publish(User $user, Article $article): bool
    {
        return $this->isCore($user);
    }

    /**
     * Check if article belongs to user
     */
    protected function isOwner(User $user, $model): bool
    {
        return $model->author_id === $user->id;
    }
}
