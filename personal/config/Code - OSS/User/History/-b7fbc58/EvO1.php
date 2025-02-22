<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class ProductController extends Controller
{
    public function show(Product $product)
    {          
        SEOTools::setTitle($product->name);
        SEOTools::setDescription($product->description);

        return view('products.show', compact('product'));
    }
}
 