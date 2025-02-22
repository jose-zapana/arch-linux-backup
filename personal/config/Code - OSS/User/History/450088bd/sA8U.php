<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WelcomeController;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

Route::get('families/{family}', [FamilyController::class, 'show'])->name('families.show');

Route::get('subcategories/{subcategory}', [SubcategoryController::class, 'show'])->name('subcategories.show');

Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

//Rutas para Blog
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('blogcategory/{blogcategory}', [PostController::class, 'blogcategory'])->name('posts.category');

Route::get('tags/{tag}', [PostController::class, 'tag'])->name('posts.tag');


Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('shipping', [ShippingController::class, 'index'])->middleware('auth')->name('shipping.index');

Route::get('checkout', [CheckoutController::class, 'index'])->middleware('auth')->name('checkout.index');

Route::post('checkout/izipay', [CheckoutController::class, 'izipay'])->name('checkout.izipay');

Route::post('checkout/niubiz', [CheckoutController::class, 'niubiz'])->name('checkout.niubiz');


Route::get('gracias', function () {
    return view('gracias');
})->name('gracias');

Route::get('terms-of-service', function () {
    return view('footer.terms');
});
Route::get('privacy-policy', function () {
    return view('footer.policy');
});

Route::get('data-protection', function () {
    return view('footer.protection');
});

Route::get('warranty-policies', function () {
    return view('footer.policies');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');


