<?php

namespace App\Providers;

// Repository
use App\Repositories\Interfaces\ProductRepositoryContract;
use App\Repositories\Functions\ProductRepository;

// Services
use App\Services\Interfaces\ProductServiceContract;
use App\Services\Functions\ProductService;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ProductServiceContract::class, ProductService::class);
    }
}
