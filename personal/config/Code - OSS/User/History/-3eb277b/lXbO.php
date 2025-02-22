<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WelcomeController;
use App\Models\Product;
use App\Models\Variant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');
Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('family/{family}', [FamilyController::class, 'show'])->name('families.show');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('subcategories/{subcategory}', [SubcategoryController::class, 'show'])->name('subcategories.show');

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('shipping', [ShippingController::class, 'index'])->middleware('auth')->name('shipping.index');
Route::get('checkout', [CheckoutController::class, 'index'])->middleware('auth')->name('checkout.index');
Route::post('checkout/paid', [CheckoutController::class, 'paid'])->name('checkout.paid');
Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');



Route::post('reviews/{product}', [ReviewController::class, 'store'])->name('reviews.store');

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



Route::get('prueba', function () {
    Cart::instance('quotation');
    return Cart::content();
});
