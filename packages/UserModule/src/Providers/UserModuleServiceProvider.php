<?php

namespace UserModule\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class UserModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register your module-specific services here
    }

    public function boot()
    {
        // Load your module routes
        $this->loadRoutes();

        // Load your module migrations
        $this->loadMigrations();

        // Load your module views
        $this->loadViews();

        // Set the default string length for the Schema
        Schema::defaultStringLength(191);
    }

    protected function loadRoutes()
    {
        Route::middleware('api')
            ->namespace('UserModule\app\Http\Controllers')
            ->group(__DIR__ . '/../routes/api.php');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'usermodule');
    }
}
