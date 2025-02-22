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
        // Configuración de SEO Dinámica
        SEOTools::setTitle($post->name); // Título del post
        SEOTools::setDescription($post->extract); // Descripción del post (extracto)
        SEOTools::setCanonical(route('posts.show', $post)); // URL canónica del post
        SEOTools::addKeyword([$post->name, 'soporte técnico', 'mantenimiento de laptops', 'venta de ordenadores', 'accesorios de computadoras', 'repuestos', 'La Molina', 'Cieneguilla', 'Manchay']);
        
        // Configuración de OpenGraph
        $imageUrl = $post->getFirstMediaUrl('images', 'posts') ?: asset('img/default_image.png'); // Imagen para OpenGraph
        SEOTools::opengraph()->setUrl(route('posts.show', $post)); // URL de la publicación
        SEOTools::opengraph()->addProperty('type', 'article'); // Tipo de contenido: artículo
        SEOTools::opengraph()->addImage($imageUrl); // Imagen para OpenGraph
        SEOTools::opengraph()->addProperty('title', $post->name); // Título de OpenGraph
        SEOTools::opengraph()->addProperty('description', $post->extract); // Descripción de OpenGraph
        
        // Configuración de Twitter Card
        SEOTools::twitter()->setTitle($post->name); // Título de Twitter Card
        SEOTools::twitter()->setSite('@pchard_sac'); // Cuenta de Twitter
        SEOTools::twitter()->setImage($imageUrl); // Imagen para Twitter Card
        
        // Configuración de JSON-LD
        SEOTools::jsonLd()->setTitle($post->name); // Título en JSON-LD
        SEOTools::jsonLd()->setDescription($post->extract); // Descripción en JSON-LD
        SEOTools::jsonLd()->addImage($imageUrl); // Imagen para JSON-LD
        
        // Asegúrate de cargar la relación
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
