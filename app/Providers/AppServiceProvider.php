<?php

namespace App\Providers;

use App\Models\Item;
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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Item::observe(ItemObserver::class);
        PurchaseOrder::observe(PurchaseOrderObserver::class);

    }
}
