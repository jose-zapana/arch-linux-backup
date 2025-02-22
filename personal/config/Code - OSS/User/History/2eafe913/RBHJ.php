<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        // Asegúrate de cargar la relación
        $post->load('blogcategory');
    
        $similares = Post::where('blogcategory_id', $post->blogcategory_id)
                        ->where('status', 2)
                        ->where('id', '!=', $post->id)
                        ->latest('id')
                        ->take(4)
                        ->get();

         
        return view('posts.show', compact('post', 'similares'));
    }
    
    public function blogcategory(blogcategory $blogcategory)
    {
        return $blogcategory;
    }
}
