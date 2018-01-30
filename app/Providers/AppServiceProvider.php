<?php

namespace App\Providers;

// Repository
use App\Repositories\Interfaces\ProductRepositoryContract;
use App\Repositories\Functions\ProductRepository;
use App\Repositories\Interfaces\CustomerRepositoryContract;
use App\Repositories\Functions\CustomerRepository;
use App\Repositories\Interfaces\OrderRepositoryContract;
use App\Repositories\Functions\OrderRepository;
use App\Repositories\Interfaces\OrderProductRepositoryContract;
use App\Repositories\Functions\OrderProductRepository;
use App\Repositories\Interfaces\UserRepositoryContract;
use App\Repositories\Functions\UserRepository;

// Services
use App\Services\Interfaces\ProductServiceContract;
use App\Services\Functions\ProductService;
use App\Services\Interfaces\CustomerServiceContract;
use App\Services\Functions\CustomerService;
use App\Services\Interfaces\OrderServiceContract;
use App\Services\Functions\OrderService;
use App\Services\Interfaces\OrderProductServiceContract;
use App\Services\Functions\OrderProductService;
use App\Services\Interfaces\UserServiceContract;
use App\Services\Functions\UserService;

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
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(UserServiceContract::class, UserService::class);

        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ProductServiceContract::class, ProductService::class);

        $this->app->bind(CustomerRepositoryContract::class, CustomerRepository::class);
        $this->app->bind(CustomerServiceContract::class, CustomerService::class);

        $this->app->bind(OrderRepositoryContract::class, OrderRepository::class);
        $this->app->bind(OrderServiceContract::class, OrderService::class);

        $this->app->bind(OrderProductRepositoryContract::class, OrderProductRepository::class);
        $this->app->bind(OrderProductServiceContract::class, OrderProductService::class);
    }
}
