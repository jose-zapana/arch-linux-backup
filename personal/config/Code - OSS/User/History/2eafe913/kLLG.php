<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Artesaos\SEOTools\Facades\SEOTools;

class PostController extends Controller
{

    use AuthorizesRequests;
    public function show(Post $post)
    {   
        SEOTools::setTitle($post->name);
        SEOTools::setDescription($post->extract);   

        // Obtención de la URL de la imagen principal
        $imageUrl = $post->getFirstMediaUrl('images', 'posts') ?: asset('https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832_960_720.jpg');

        // Configuración de Open Graph y Twitter Card
        SEOTools::opengraph()->addImage($imageUrl);
        SEOTools::twitter()->setImage($imageUrl);



        $this->authorize('published', $post);
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
