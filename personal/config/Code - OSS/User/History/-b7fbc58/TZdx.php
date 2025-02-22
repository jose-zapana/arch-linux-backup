<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class ProductController extends Controller
{
    public function show(Product $product)
    {   
        dd($product);
        SEOTools::setTitle($product->name);
        SEOTools::setDescription($product>extract);

        return view('products.show', compact('product'));
    }
}
 