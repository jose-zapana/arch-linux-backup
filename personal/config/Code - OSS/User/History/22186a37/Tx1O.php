<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class SubcategoryController extends Controller
{
    public function show(Subcategory $subcategory)
    {
        // Configuración dinámica del título y descripción SEO
        SEOTools::setTitle("Subcategoría: {$subcategory->name} | PC-HARD S.A.C.");
        SEOTools::setDescription("Descubre nuestra subcategoría {$subcategory->name} en PC-HARD S.A.C. Ofrecemos productos tecnológicos de alta calidad y servicios especializados en soporte y mantenimiento de ordenadores y laptops, disponibles en La Molina, Cieneguilla y Manchay.");
        
        return view('subcategories.show', compact('subcategory'));
    }
}
