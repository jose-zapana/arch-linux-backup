<?php

namespace App\Http\Controllers;

use App\Models\Cover;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\JsonLdMulti;

use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
    {
        // Configuración de SEOTools usando JsonLdMulti
        JsonLdMulti::setTitle('PCHARD SAC');
        JsonLdMulti::setDescription('PC-HARD S.A.C. ofrece soluciones completas en tecnología: venta de computadoras, laptops, impresoras y accesorios. Especialistas en soporte técnico y mantenimiento en La Molina, Cieneguilla y Manchay.');
        JsonLdMulti::setType('WebPage');
        JsonLdMulti::addImage(asset('img/default_image.png')); // Imagen predeterminada
    
        // Configuración adicional para redes sociales
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebSite');
            JsonLdMulti::setTitle('PC-HARD Technology');
        }
    
        // Determina la página actual para usar en la clave de caché
        $page = request()->get('page', 1); // '1' es el valor predeterminado si no se especifica la página
        $cacheDuration = 60; // Duración de caché en minutos
    
        // 1. Obtener los posts
        $postsKey = "posts-{$page}";
        $posts = Cache::remember($postsKey, $cacheDuration, function () {
            return Post::where('status', 2)->latest('id')->paginate(5);
        });
    
        // 2. Obtener los últimos productos
        $lastProductsKey = "lastProducts-{$page}";
        $lastProducts = Cache::remember($lastProductsKey, $cacheDuration, function () {
            return Product::orderBy('created_at', 'desc')->take(8)->get();
        });
    
        // 3. Obtener los covers
        $coversKey = "covers";
        $covers = Cache::remember($coversKey, $cacheDuration, function () {
            return Cover::where('is_active', true)
                ->whereDate('start_at', '<=', now())
                ->where(function ($query) {
                    $query->whereDate('end_at', '>=', now())
                        ->orWhereNull('end_at');
                })
                ->get();
        });
    
        // Retorna la vista con los datos necesarios
        return view('welcome', compact('covers', 'lastProducts', 'posts'));
    }
    
}
