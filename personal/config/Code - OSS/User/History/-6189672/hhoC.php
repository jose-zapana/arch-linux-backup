<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        \App\Models\Cover::observe(\App\Observers\CoverObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
        \App\Models\Post::observe(\App\Observers\PostObserver::class);
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        \App\Models\Variant::observe(\App\Observers\VariantObserver::class);
        \App\Models\Quotation::observe(\App\Observers\QuoteObserver::class);

    }
}
