<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class FamilyController extends Controller
{
    public function show(Family $family)
    {
        // Configuración dinámica del título y descripción SEO
        SEOTools::setTitle("Familia: {$family->name} | PC-HARD S.A.C.");
        SEOTools::setDescription("Explora la familia de productos {$family->name} en PC-HARD S.A.C. Descubre nuestra amplia gama de computadoras, laptops, repuestos y accesorios tecnológicos. Servicios especializados en soporte y mantenimiento de equipos, disponibles en La Molina, Cieneguilla y Manchay.");
        
        return view('families.show', compact('family'));
    }
}
