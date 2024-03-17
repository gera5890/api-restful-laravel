<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(Post $post, User $user): bool
    {
        return $post->user_id == $user->id || $user->hasAnyPermission('admin') ? true : false;
    }

    public function delete(User $user, Post $post): bool
    {
        return $post->user_id == $user->id || $user->hasAnyPermission('admin') ? true : false;
    }
}
