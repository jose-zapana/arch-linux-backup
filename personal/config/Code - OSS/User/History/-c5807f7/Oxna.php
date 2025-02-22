<?php

namespace App\Policies;

use App\Models\User;

class PostPolicy
{

    public function author(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

}
