<?php

namespace App\Providers;

use App\Macros\CustomResponseMacros;
use App\Models\PurchaseOrder;
use App\Observers\PurchaseOrderObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        CustomResponseMacros::register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PurchaseOrder::observe(PurchaseOrderObserver::class);
    }
}
