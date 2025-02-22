<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        SEOTools::setTitle($post->name);
        SEOTools::setDescription($post->extract);

        return view('products.show', compact('product'));
    }
}
 