<?php

namespace App\Providers;

use App\Macros\CustomResponseMacros;
use App\Models\Address;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Observers\PurchaseOrderObserver;
use App\Repositories\AddressRepository;
use App\Repositories\UserRepository;
use App\Support\CounterService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        CustomResponseMacros::register();

//        $this->app->bind('UserRepository', function ($app) {
//            return new UserRepository(new User());
//        });
//
//        $this->app->bind('AddressRepository', function ($app) {
//            return new AddressRepository(new Address());
//        });

//        $this->app->singleton('UserRepository', function ($app) {
//            return new UserRepository(new User());
//        });
//
//        $this->app->singleton('AddressRepository', function ($app) {
//            return new AddressRepository(new Address());
//        });


        $this->app->singleton(
            'test1',
            \App\Support\CounterService::class
        );

        $this->app->bind(
            'test2',
            \App\Support\CounterService::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PurchaseOrder::observe(PurchaseOrderObserver::class);
    }
}
