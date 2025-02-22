<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    public function creating(Post $post)
    {   
        if(! \App::runningInConsole()){
            $post->user_id = auth()->user()->id;
        }
        
    }
}
