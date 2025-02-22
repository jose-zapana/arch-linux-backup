<?php

namespace App\Providers;

use App\Services\CategoryTagService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CategoryTagService::class, function ($app) { return new CategoryTagService(); });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Cover::observe(\App\Observers\CoverObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
    }
}
