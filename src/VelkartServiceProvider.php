<?php

namespace IndieHD\Velkart;

use Illuminate\Support\ServiceProvider;
use IndieHD\Velkart\Product\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Product\Repositories\ProductRepository;
use IndieHD\Velkart\ProductImage\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\ProductImage\Repositories\ProductImageRepository;

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
    }
}
