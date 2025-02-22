<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\CoverController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DenominationController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Driver;
use App\Models\Post;
use App\Models\Quotation;
use App\Models\Shipment;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Inertia\CurrentUserController;

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

Route::get('/', function () {
    return view('admin.dashboard');
})->middleware(['can:access dashboard'])->name('dashboard');

Route::get('/options', [OptionController::class, 'index'])
->middleware(['can:manage options'])->name('options.index');

Route::resource('families', FamilyController::class)->middleware(['can:manage families']);

Route::resource('categories', CategoryController::class)
    ->middleware(['can:manage categories']);

Route::resource('subcategories', SubcategoryController::class)
    ->middleware(['can:manage subcategories']);

//Ruta de Clientes
Route::resource('customers', CustomerController::class);
//Ruta de Productos
Route::resource('products', ProductController::class)
    ->middleware(['can:manage products']);

Route::resource('denominations', DenominationController::class);

Route::get('cart', [CartController::class, 'index'])->name('cart.index');

Route::get('sales', [SaleController::class, 'index'])->name('sales.index');

Route::resource('quotes', QuotationController::class);

Route::get('quotes/generatepdf/{quote}', [QuotationController::class, 'generatePdf'])
    ->name('quotes.generatepdf');

Route::resource('roles', RoleController::class);

Route::resource('drivers', DriverController::class)
    ->middleware(['can:manage drivers']);

Route::get('shipments', [ShipmentController::class, 'index'])->name('shipments.index');

Route::get('orders', [OrderController::class, 'index'])->name('orders.index');


//Ruta de Cotizacionestags?page=2
Route::resource('Cotiza', ProductController::class)
    ->middleware(['can:manage products']);

Route::get('products/{product}/variants/{variant}', [ProductController::class, 'variants'])
    ->name('products.variants')
    ->scopeBindings();

Route::put('products/{product}/variants/{variant}', [ProductController::class, 'variantsUpdate'])
    ->name('products.variantsUpdate')
    ->scopeBindings();

Route::resource('covers', CoverController::class)
    ->middleware(['can:manage covers']);
Route::resource('users', UserController::class)
    ->middleware(['can:manage users']);

//Ruta para Blog

Route::resource('post/categories', PostController::class)
    ->middleware(['can:manage posts'])->names('posts.categories');

Route::resource('tags', TagController::class)->names('tags')
    ->middleware(['can:manage tags']);

Route::resource('blogs', BlogController::class)->names('blogs')
    ->middleware(['can:manage posts']);

Route::post('ckeditor/upload', [blogController::class, 'upload'])->name('ckeditor.upload');


Route::get('prueba', function () {
    $quotations = Quotation::first();
    return view('admin.pdf.quotation', compact('quotations'));
});

