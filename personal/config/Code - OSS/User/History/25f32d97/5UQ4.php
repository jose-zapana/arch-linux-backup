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
        SEOTools::setTitle("Catálogo: {$family->name} | PC-HARD S.A.C.");
        SEOTools::setDescription("Explora nuestro catálogo de {$family->name} en PC-HARD SAC, con una amplia variedad de computadoras, repuestos y accesorios tecnológicos. Ofrecemos mantenimiento a domicilio, soporte técnico remoto y entrega de productos en La Molina, Cieneguilla y Manchay.");

        
        return view('families.show', compact('family'));
    }
}
