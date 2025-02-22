<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class CategoryController extends Controller
{
    public function show(Category $category)
    {   

        SEOTools::setTitle($product->name);
        SEOTools::setDescription($product->description);

        return view('categories.show', compact('category'));
    }
}
