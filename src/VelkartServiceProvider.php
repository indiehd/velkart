<?php

namespace IndieHD\Velkart;

use Illuminate\Support\ServiceProvider;
use IndieHD\Velkart\Contracts\AttributeRepositoryContract;
use IndieHD\Velkart\Contracts\AttributeValueRepositoryContract;
use IndieHD\Velkart\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Repositories\Eloquent\AttributeRepository;
use IndieHD\Velkart\Repositories\Eloquent\AttributeValueRepository;
use IndieHD\Velkart\Repositories\Eloquent\ProductRepository;
use IndieHD\Velkart\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\Repositories\Eloquent\ProductImageRepository;
use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Repositories\Eloquent\OrderRepository;

class VelkartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    public function register()
    {
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ProductImageRepositoryContract::class, ProductImageRepository::class);
        $this->app->bind(OrderRepositoryContract::class, OrderRepository::class);
        $this->app->bind(AttributeRepositoryContract::class, AttributeRepository::class);
        $this->app->bind(AttributeValueRepositoryContract::class, AttributeValueRepository::class);
    }
}
