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
use App\Repositories\Interfaces\OutletProductRepositoryContract;
use App\Repositories\Functions\OutletProductRepository;
use App\Repositories\Interfaces\SupplierProductRepositoryContract;
use App\Repositories\Functions\SupplierProductRepository;
use App\Repositories\Interfaces\SupplierRepositoryContract;
use App\Repositories\Functions\SupplierRepository;

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
use App\Services\Interfaces\OutletProductServiceContract;
use App\Services\Functions\OutletProductService;
use App\Services\Interfaces\SupplierProductServiceContract;
use App\Services\Functions\SupplierProductService;
use App\Services\Interfaces\SupplierServiceContract;
use App\Services\Functions\SupplierService;

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
        $this->app->bind(SupplierRepositoryContract::class, SupplierRepository::class);
        $this->app->bind(SupplierServiceContract::class, SupplierService::class);

        $this->app->bind(SupplierProductRepositoryContract::class, SupplierProductRepository::class);
        $this->app->bind(SupplierProductServiceContract::class, SupplierProductService::class);

        $this->app->bind(OutletProductRepositoryContract::class, OutletProductRepository::class);
        $this->app->bind(OutletProductServiceContract::class, OutletProductService::class);

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
