<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OrderService;
use App\Services\UserService;
use App\Repositories\{OrderRepositoryInterface,OrderRepository};
use App\Repositories\{OrderItemRepositoryInterface,OrderItemRepository};
use App\Repositories\{BuyerRepositoryInterface,BuyerRepository};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Registrar OrderService
        $this->app->singleton(OrderService::class, function ($app) {
            return new OrderService();
        });

        // Registrar UserService
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        $this->app->bind(
            OrderItemRepositoryInterface::class,
            OrderItemRepository::class
        );
        $this->app->bind(
            BuyerRepositoryInterface::class,
            BuyerRepository::class
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
