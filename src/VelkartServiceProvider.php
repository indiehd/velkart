<?php

namespace IndieHD\Velkart;

use Illuminate\Support\ServiceProvider;
use IndieHD\Velkart\Contracts\AddressRepositoryContract;
use IndieHD\Velkart\Contracts\AttributeRepositoryContract;
use IndieHD\Velkart\Contracts\AttributeValueRepositoryContract;
use IndieHD\Velkart\Contracts\CountryRepositoryContract;
use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\OrderStatusRepositoryContract;
use IndieHD\Velkart\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Repositories\Eloquent\AddressRepository;
use IndieHD\Velkart\Repositories\Eloquent\AttributeRepository;
use IndieHD\Velkart\Repositories\Eloquent\AttributeValueRepository;
use IndieHD\Velkart\Repositories\Eloquent\CountryRepository;
use IndieHD\Velkart\Repositories\Eloquent\OrderRepository;
use IndieHD\Velkart\Repositories\Eloquent\OrderStatusRepository;
use IndieHD\Velkart\Repositories\Eloquent\ProductImageRepository;
use IndieHD\Velkart\Repositories\Eloquent\ProductRepository;

class VelkartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    public function register()
    {
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ProductImageRepositoryContract::class, ProductImageRepository::class);
        $this->app->bind(AddressRepositoryContract::class, AddressRepository::class);
        $this->app->bind(CountryRepositoryContract::class, CountryRepository::class);
        $this->app->bind(OrderStatusRepositoryContract::class, OrderStatusRepository::class);
        $this->app->bind(OrderRepositoryContract::class, OrderRepository::class);
        $this->app->bind(AttributeRepositoryContract::class, AttributeRepository::class);
        $this->app->bind(AttributeValueRepositoryContract::class, AttributeValueRepository::class);
    }
}
