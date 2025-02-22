<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function show(Post $post)
    {   
        // Configuración de SEO Dinámica con SEOMeta
        SEOMeta::setTitle($post->name); // Título del post
        SEOMeta::setDescription(strip_tags($post->extract)); // Descripción del post (extracto)
        SEOMeta::setCanonical(route('posts.show', $post)); // URL canónica del post        
        // Configuración de OpenGraph
        $imageUrl = $post->getFirstMediaUrl('images', 'posts') ?: asset('img/default_image.png'); // Imagen para OpenGraph
        OpenGraph::setTitle($post->name); // Título para OpenGraph
        OpenGraph::setDescription(strip_tags($post->extract)); // Descripción para OpenGraph
        OpenGraph::setUrl(route('posts.show', $post)); // URL de la publicación
        OpenGraph::addProperty('type', 'article'); // Tipo de contenido: artículo
        OpenGraph::addImage($imageUrl); // Imagen para OpenGraph

        // Configuración de Twitter Card
        TwitterCard::setTitle($post->name); // Título para Twitter Card
        TwitterCard::setSite('@pchard_sac'); // Cuenta de Twitter
        TwitterCard::setImage($imageUrl); // Imagen para Twitter Card
        
        // Configuración de JSON-LD
        JsonLd::setTitle($post->name); // Título en JSON-LD
        JsonLd::setDescription(strip_tags($post->extract)); // Eliminar etiquetas HTML de la descripción
        JsonLd::addImage($imageUrl); // Imagen para JSON-LD
        
        // Asegúrate de cargar la relación

        $this->authorize('published', $post);
        $post->load('blogcategory');
    
        // Obtener los posts similares (basados en la misma categoría)
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
        $posts = Post::where('blogcategory_id', $blogcategory->id)
                     ->where('status', 2)
                     ->latest('id')
                     ->paginate(4);

        return view('posts.category', compact('posts', 'blogcategory'));
    }

    public function tag(Tag $tag)
    {
        $posts = $tag->posts()->where('status', 2)->latest('id')->paginate(4);

        return view('posts.tag', compact('posts', 'tag'));
    }
}
