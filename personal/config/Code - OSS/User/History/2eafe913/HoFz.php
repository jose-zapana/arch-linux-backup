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
        SEOTools::setTitle($post->name); // Establecer el título de la página
        SEOTools::setDescription($post->extract); // Establecer la descripción de la página
    
        // Establecer la URL de la imagen principal o usar la imagen predeterminada
        $imageUrl = $post->getFirstMediaUrl('images', 'posts') ?: asset('default_image.png');
        
        // Configuración de Open Graph y Twitter Card
        SEOTools::opengraph()->setUrl(route('posts.show', $post)); // URL de la publicación
        SEOTools::opengraph()->addProperty('type', 'article'); // Tipo de contenido (artículo)
        SEOTools::opengraph()->addImage($imageUrl); // Imagen para Open Graph
        SEOTools::twitter()->setSite('@TuCuentaTwitter'); // Cuenta de Twitter
        SEOTools::twitter()->setImage($imageUrl); // Imagen para Twitter Card

        dd($imageUrl);
    
        // Asegúrate de cargar la relación
        $post->load('blogcategory');
    
        // Obtener los posts similares
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
