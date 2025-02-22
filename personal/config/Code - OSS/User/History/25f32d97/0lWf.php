<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use App\Models\Product;

class FamilyController extends Controller
{
    public function show(Family $family)
    {

        $product = Product::latest()->first();
        if ($product && $product->hasMedia('products')) {
            $imageUrl = $product->getFirstMediaUrl('products'); // Imagen del último producto
        }

        // Configuración dinámica del título y descripción SEO
        SEOMeta::setTitle("Catálogo: {$family->name}"); // Título del catálogo
        SEOMeta::setDescription("Explora nuestro catálogo de {$family->name}, con una amplia variedad de computadoras, repuestos y accesorios tecnológicos. Ofrecemos mantenimiento a domicilio, soporte técnico remoto y entrega de productos en La Molina, Cieneguilla y Manchay."); // Descripción del catálogo
        SEOMeta::setCanonical(route('families.show', $family)); // URL canónica del catálogo

        // Configuración de OpenGraph
        $imageUrl = $family->getFirstMediaUrl('images', 'families') ?: asset('img/default_image.png'); // Imagen para OpenGraph
        OpenGraph::setTitle("Catálogo: {$family->name}"); // Título para OpenGraph
        OpenGraph::setDescription("Explora nuestro catálogo de {$family->name}, con una amplia variedad de computadoras, repuestos y accesorios tecnológicos."); // Descripción para OpenGraph
        OpenGraph::setUrl(route('families.show', $family)); // URL de la página del catálogo
        OpenGraph::addProperty('type', 'website'); // Tipo de contenido: website
        OpenGraph::addImage($imageUrl); // Imagen para OpenGraph

        // Configuración de Twitter Card
        TwitterCard::setTitle("Catálogo: {$family->name}"); // Título para Twitter Card
        TwitterCard::setSite('@pchard_sac'); // Cuenta de Twitter
        TwitterCard::setImage($imageUrl); // Imagen para Twitter Card

        // Configuración de JSON-LD
        JsonLd::setTitle("Catálogo: {$family->name}"); // Título en JSON-LD
        JsonLd::setDescription("Explora nuestro catálogo de {$family->name}, con una amplia variedad de computadoras, repuestos y accesorios tecnológicos."); // Descripción en JSON-LD
        JsonLd::addImage($imageUrl); // Imagen para JSON-LD

        // Cargar las categorías relacionadas (si existen)
        $family->load('categories');

        
        return view('families.show', compact('family'));
    }
}
