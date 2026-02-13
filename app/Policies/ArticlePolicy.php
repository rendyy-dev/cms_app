<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Article $article): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole([
            'author',
            'admin',
            'super_admin',
        ]);
    }

    public function update(User $user, Article $article): bool
    {
        // Super admin & admin bebas
        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            return true;
        }

        // Editor bisa edit selama belum publish
        if ($user->hasRole('editor')) {
            return $article->status !== 'published';
        }

        // Author hanya bisa edit miliknya dan hanya saat draft
        if ($user->hasRole('author')) {
            return $article->user_id === $user->id
                && $article->status === 'draft';
        }

        return false;
    }

    public function submit(User $user, Article $article): bool
    {
        return $user->hasRole('author')
            && $article->user_id === $user->id
            && $article->status === 'draft';
    }

    public function approve(User $user, Article $article): bool
    {
        return $user->hasAnyRole([
            'editor',
            'admin',
            'super_admin',
        ]) && $article->status === 'pending';
    }

    public function reject(User $user, Article $article): bool
    {
        return $user->hasAnyRole([
            'editor',
            'admin',
            'super_admin',
        ]) && $article->status === 'pending';
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->hasAnyRole(['super_admin']);
    }
}
