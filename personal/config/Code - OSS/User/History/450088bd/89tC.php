<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FamilyController;
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

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('shipping', [ShippingController::class, 'index'])->middleware('auth')->name('shipping.index');

Route::get('checkout', [CheckoutController::class, 'index'])->middleware('auth')->name('checkout.index');

Route::post('checkout/izipay', [CheckoutController::class, 'izipay'])->name('checkout.izipay');

Route::post('checkout/niubiz', [CheckoutController::class, 'niubiz'])->name('checkout.niubiz');


Route::get('gracias', function () {
    return view('gracias');
})->name('gracias');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('prueba', function () {
    $order= Order::first();

    $pdf = Pdf::loadView('orders.ticket', compact('order'))->setPaper('a5');
    
    $pdf->save(storage_path('public/tickets/ticket-' . $order->id . '.pdf'));

    return view('orders.ticket', compact('order'));


}); 