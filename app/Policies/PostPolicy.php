<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('posts.view');
    }

    public function view(User $user, Post $post): bool
    {
        if (! $user->hasPermissionTo('posts.view')) {
            return false;
        }

        if ($user->hasRole('super-admin') || $user->hasRole('editor')) {
            return true;
        }

        return $user->assignedPosts()->whereKey($post->id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('posts.create');
    }

    public function update(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('posts.update');
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('posts.delete');
    }
}
