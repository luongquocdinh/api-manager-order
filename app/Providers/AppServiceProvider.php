<?php

namespace App\Providers;

// Repository
use App\Repositories\Interfaces\ProductRepositoryContract;
use App\Repositories\Functions\ProductRepository;
use App\Repositories\Interfaces\CustomerRepositoryContract;
use App\Repositories\Functions\CustomerRepository;

// Services
use App\Services\Interfaces\ProductServiceContract;
use App\Services\Functions\ProductService;
use App\Services\Interfaces\CustomerServiceContract;
use App\Services\Functions\CustomerService;

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

        $this->app->bind(CustomerRepositoryContract::class, CustomerRepository::class);
        $this->app->bind(CustomerServiceContract::class, CustomerService::class);
    }
}
