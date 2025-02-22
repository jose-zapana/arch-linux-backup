<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class CategoryController extends Controller
{
    public function show(Category $category)
    {   

        // Configuración dinámica del título y descripción SEO
        SEOTools::setTitle("Categoría: {$category->name} | PC-HARD S.A.C.");
        SEOTools::setDescription("Explora nuestra categoría {$category->name} en PC-HARD S.A.C. Encuentra los mejores productos tecnológicos y servicios especializados en computadoras, laptops y accesorios en La Molina, Cieneguilla y Manchay.");

        return view('categories.show', compact('category'));
    }
}
