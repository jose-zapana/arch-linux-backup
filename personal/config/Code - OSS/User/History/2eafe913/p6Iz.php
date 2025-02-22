<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
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
        $posts = Post::where('blogcategory_id', $blogcategory->id)->where('status', 2)->latest('id')->paginate(4);

        return view('posts.category', compact('posts', 'blogcategory'));
    }

    public function tag(Tag $tag)
    {
        $posts = $tag->posts()->where('status', 2)->latest('id')->paginate(4);  

        return view('posts.tag', compact('posts', 'tag'));
    }
}
