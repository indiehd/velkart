<?php

namespace IndieHD\Velkart;

use Illuminate\Support\ServiceProvider;
use IndieHD\Velkart\Contracts\ProductImageRepositoryContract;
use IndieHD\Velkart\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Contracts\CategoryRepositoryContract;
use IndieHD\Velkart\Repositories\Eloquent\ProductImageRepository;
use IndieHD\Velkart\Repositories\Eloquent\CategoryRepository;
use IndieHD\Velkart\Repositories\Eloquent\ProductRepository;

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
        $this->app->bind(CategoryRepositoryContract::class, CategoryRepository::class);
    }
}
