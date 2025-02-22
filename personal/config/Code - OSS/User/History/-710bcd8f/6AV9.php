<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class CategoryController extends Controller
{
    public function show(Category $category)
    {   

        // Configuración dinámica del título y descripción SEO con SEOMeta
        SEOMeta::setTitle("Categoría: {$category->name}"); // Título de la categoría
        SEOMeta::setDescription("Explora nuestra categoría {$category->name} en PC-HARD S.A.C. Encuentra los mejores productos tecnológicos y servicios especializados en computadoras, laptops y accesorios en La Molina, Cieneguilla y Manchay."); // Descripción de la categoría
        SEOMeta::setCanonical(route('categories.show', $category)); // URL canónica de la categoría

        // Configuración de OpenGraph
        $imageUrl = $category->getFirstMediaUrl('images', 'categories') ?: asset('img/default_image.png'); // Imagen para OpenGraph, si no tiene se usa la predeterminada
        OpenGraph::setTitle("Categoría: {$category->name}"); // Título para OpenGraph
        OpenGraph::setDescription("Explora nuestra categoría {$category->name}, con productos tecnológicos de alta calidad."); // Descripción para OpenGraph
        OpenGraph::setUrl(route('categories.show', $category)); // URL de la categoría
        OpenGraph::addProperty('type', 'website'); // Tipo de contenido: website
        OpenGraph::addImage($imageUrl); // Imagen para OpenGraph

        // Configuración de Twitter Card
        TwitterCard::setTitle("Categoría: {$category->name}"); // Título para Twitter Card
        TwitterCard::setSite('@pchard_sac'); // Cuenta de Twitter
        TwitterCard::setImage($imageUrl); // Imagen para Twitter Card

        // Configuración de JSON-LD
        JsonLd::setTitle("Categoría: {$category->name}"); // Título en JSON-LD
        JsonLd::setDescription("Explora nuestra categoría {$category->name} en PC-HARD S.A.C., con productos tecnológicos de alta calidad y servicios especializados."); // Descripción en JSON-LD
        JsonLd::addImage($imageUrl); // Imagen para JSON-LD

        return view('categories.show', compact('category'));
    }
}
