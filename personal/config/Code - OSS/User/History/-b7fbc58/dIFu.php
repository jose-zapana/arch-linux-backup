<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
    public function catalog()
    {
        $categories = Category::where('shop_id', 1)->get();
        return view('landing.catalog', compact('categories'));
    }
}
