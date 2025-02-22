<?php

namespace App\Http\Controllers;

use App\Models\Cover;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;


use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
    {

        SEOMeta::setTitle('PCHARD SAC');
        SEOMeta::setDescription('PC-HARD SAC ofrece soluciones completas en tecnología: venta de computadoras, laptops, impresoras y accesorios. Especialistas en soporte técnico y mantenimiento en La Molina, Cieneguilla y Manchay.');
        SEOMeta::setCanonical('https://pc-hard.com');
        SEOMeta::addKeyword(['soporte técnico', 'mantenimiento de laptops', 'venta de ordenadores', 'accesorios de computadoras', 'repuestos', 'La Molina', 'Cieneguilla', 'Manchay']);
        
        OpenGraph::setTitle('PCHARD SAC');
        OpenGraph::setDescription('PC-HARD SAC ofrece soluciones completas en tecnología: venta de computadoras, laptops, impresoras y accesorios. Especialistas en soporte técnico y mantenimiento en La Molina, Cieneguilla y Manchay.');
        OpenGraph::setUrl('https://pc-hard.com');
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addImage('http://image.url.com/cover.jpg', ['height' => 300, 'width' => 300]);

        
        TwitterCard::setTitle('PCHARD SAC');
        TwitterCard::setSite('@pchard_sac');
        
        JsonLd::setTitle('PCHARD SAC');
        JsonLd::setDescription('PC-HARD SAC ofrece soluciones completas en tecnología: venta de computadoras, laptops, impresoras y accesorios. Especialistas en soporte técnico y mantenimiento en La Molina, Cieneguilla y Manchay.');
        JsonLd::addImage(asset('img/default_image.png'));
        



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
