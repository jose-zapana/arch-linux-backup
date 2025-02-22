<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;
    public function author(User $user, Post $post)
    {
        if ($user->id == $post->user_id) {
            return true;
        }
        return false;   
    }

    public function published(User $user, Post $post)
    {
        if ($post->status == 'published') {
            return true;
        }
        return false;   
    }

}
