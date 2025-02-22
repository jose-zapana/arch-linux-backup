<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class SubcategoryController extends Controller
{
    public function show(Subcategory $subcategory)
    {
        // Configuración dinámica del título y descripción SEO con SEOMeta
        SEOMeta::setTitle("Subcategoría: {$subcategory->name}"); // Título de la subcategoría
        SEOMeta::setDescription("Descubre nuestra subcategoría {$subcategory->name} en PC-HARD S.A.C. Ofrecemos productos tecnológicos de alta calidad y servicios especializados en soporte y mantenimiento de ordenadores y laptops, disponibles en La Molina, Cieneguilla y Manchay."); // Descripción de la subcategoría
        SEOMeta::setCanonical(route('subcategories.show', $subcategory)); // URL canónica de la subcategoría

        // Configuración de OpenGraph
        $imageUrl = asset('img/catalogo.webp'); // Imagen para OpenGraph, si no tiene se usa la predeterminada
        OpenGraph::setTitle("Subcategoría: {$subcategory->name}"); // Título para OpenGraph
        OpenGraph::setDescription("Descubre nuestra subcategoría {$subcategory->name}, con productos tecnológicos de alta calidad."); // Descripción para OpenGraph
        OpenGraph::setUrl(route('subcategories.show', $subcategory)); // URL de la subcategoría
        OpenGraph::addProperty('type', 'website'); // Tipo de contenido: website
        OpenGraph::addImage($imageUrl); // Imagen para OpenGraph

        // Configuración de Twitter Card
        TwitterCard::setTitle("Subcategoría: {$subcategory->name}"); // Título para Twitter Card
        TwitterCard::setSite('@pchard_sac'); // Cuenta de Twitter
        TwitterCard::setImage($imageUrl); // Imagen para Twitter Card

        // Configuración de JSON-LD
        JsonLd::setTitle("Subcategoría: {$subcategory->name}"); // Título en JSON-LD
        JsonLd::setDescription("Descubre nuestra subcategoría {$subcategory->name} en PC-HARD S.A.C., con productos tecnológicos de alta calidad y servicios especializados."); // Descripción en JSON-LD
        JsonLd::addImage($imageUrl); // Imagen para JSON-LD
        
        return view('subcategories.show', compact('subcategory'));
    }
}
