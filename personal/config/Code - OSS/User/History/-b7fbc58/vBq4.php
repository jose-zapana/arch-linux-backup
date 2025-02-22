<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class ProductController extends Controller
{
    public function show(Product $product)
    {          
    // Configuración dinámica del título y descripción SEO con SEOMeta
    SEOMeta::setTitle($product->name); // Título del producto
    SEOMeta::setDescription(strip_tags($product->description)); // Descripción del producto sin etiquetas HTML
    SEOMeta::setCanonical(route('products.show', $product)); // URL canónica del producto

    // Configuración de OpenGraph
    $imageUrl = $product->getFirstMediaUrl('images', 'product') ?: asset('img/no-image.png'); // Imagen para OpenGraph, si no tiene se usa la predeterminada
    OpenGraph::setTitle($product->name); // Título para OpenGraph
    OpenGraph::setDescription(strip_tags($product->description)); // Descripción para OpenGraph sin etiquetas HTML
    OpenGraph::setUrl(route('products.show', $product)); // URL del producto
    OpenGraph::addProperty('type', 'product'); // Tipo de contenido: producto
    OpenGraph::addImage($imageUrl); // Imagen para OpenGraph

    // Configuración de Twitter Card
    TwitterCard::setTitle($product->name); // Título para Twitter Card
    TwitterCard::setSite('@pchard_sac'); // Cuenta de Twitter
    TwitterCard::setImage($imageUrl); // Imagen para Twitter Card

    // Configuración de JSON-LD
    JsonLd::setTitle($product->name); // Título en JSON-LD
    JsonLd::setDescription(strip_tags($product->description)); // Descripción en JSON-LD sin etiquetas HTML
    JsonLd::addImage($imageUrl); // Imagen para JSON-LD


        return view('products.show', compact('product'));
    }
}
 