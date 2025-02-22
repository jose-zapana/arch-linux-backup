<?php

namespace App\Http\Controllers;

use App\Models\Cover;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;


use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
    {

        SEOTools::setTitle('PCHARD SAC');
        SEOTools::setDescription('PC-HARD S.A.C. ofrece soluciones completas en tecnología: venta de computadoras, laptops, impresoras y accesorios. Especialistas en soporte técnico y mantenimiento en La Molina, Cieneguilla y Manchay.');
        SEOTools::opengraph()->setUrl('https://pc-hard.com'); // URL correcta
        SEOTools::setCanonical('https://pc-hard.com'); // URL canónica
        SEOTools::opengraph()->addProperty('type', 'website'); // Tipo de contenido
        SEOTools::twitter()->setSite('@PCHARD_SAC'); // Twitter Handle
        SEOTools::jsonLd()->addImage('img/default_image.png'); // Imagen de JSON-LD      
        


        // Determina la página actual para usar en la clave de caché
        $page = request()->get('page', 1); // '1' es el valor predeterminado si no se especifica la página
        $cacheDuration = 60; // Duración de caché en minutos
    
        // 1. Obtener los posts
        $postsKey = "posts-{$page}";
        if (Cache::has($postsKey)) {
            $posts = Cache::get($postsKey);
        } else {
            $posts = Post::where('status', 2)->latest('id')->paginate(5);
            Cache::put($postsKey, $posts, $cacheDuration);
        }
    
        // 2. Obtener los últimos productos
        $lastProductsKey = "lastProducts-{$page}";
        if (Cache::has($lastProductsKey)) {
            $lastProducts = Cache::get($lastProductsKey);
        } else {
            $lastProducts = Product::orderBy('created_at', 'desc')->take(8)->get();
            Cache::put($lastProductsKey, $lastProducts, $cacheDuration);
        }
    
        // 3. Obtener los covers (sin paginación)
        $coversKey = "covers"; // No depende de la página, es un solo conjunto de covers
        if (Cache::has($coversKey)) {
            $covers = Cache::get($coversKey);
        } else {
            // No es necesario paginar, solo obtener todos los covers activos
            $covers = Cover::where('is_active', true)
                ->whereDate('start_at', '<=', now())
                ->where(function ($query) {
                    $query->whereDate('end_at', '>=', now())
                        ->orWhereNull('end_at');
                })
                ->get();
            Cache::put($coversKey, $covers, $cacheDuration);
        }
    
        // Retorna la vista con los datos necesarios
        return view('welcome', compact('covers', 'lastProducts', 'posts'));
    }
}
