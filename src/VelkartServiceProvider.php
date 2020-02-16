<?php

namespace IndieHD\Velkart;

use Illuminate\Support\ServiceProvider;
use IndieHD\Velkart\Cart\CartItem;
use IndieHD\Velkart\Contracts\Models\CartItemContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\AddressRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\AttributeRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\AttributeValueRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CartRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CategoryRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CountryRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderStatusRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\ProductImageRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\ProductRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartItemRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartSessionRepositoryContract;
use IndieHD\Velkart\Repositories\Eloquent\AddressRepository;
use IndieHD\Velkart\Repositories\Eloquent\AttributeRepository;
use IndieHD\Velkart\Repositories\Eloquent\AttributeValueRepository;
use IndieHD\Velkart\Repositories\Eloquent\CartRepository;
use IndieHD\Velkart\Repositories\Eloquent\CategoryRepository;
use IndieHD\Velkart\Repositories\Eloquent\CountryRepository;
use IndieHD\Velkart\Repositories\Eloquent\OrderRepository;
use IndieHD\Velkart\Repositories\Eloquent\OrderStatusRepository;
use IndieHD\Velkart\Repositories\Eloquent\ProductImageRepository;
use IndieHD\Velkart\Repositories\Eloquent\ProductRepository;
use IndieHD\Velkart\Repositories\Session\CartItemRepository;
use IndieHD\Velkart\Repositories\Session\CartSessionRepository;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;

class VelkartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->publishes([
            __DIR__ . '/Config/cart.php' => config_path('velkart.cart.php'),
        ]);

        config(['cart' => array_merge_recursive(config('cart') ?? [], config('velkart.cart'))]);
    }

    public function register()
    {
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(ProductImageRepositoryContract::class, ProductImageRepository::class);
        $this->app->bind(CategoryRepositoryContract::class, CategoryRepository::class);
        $this->app->bind(AddressRepositoryContract::class, AddressRepository::class);
        $this->app->bind(CountryRepositoryContract::class, CountryRepository::class);
        $this->app->bind(OrderStatusRepositoryContract::class, OrderStatusRepository::class);
        $this->app->bind(OrderRepositoryContract::class, OrderRepository::class);
        $this->app->bind(AttributeRepositoryContract::class, AttributeRepository::class);
        $this->app->bind(AttributeValueRepositoryContract::class, AttributeValueRepository::class);
        $this->app->bind(CartRepositoryContract::class, CartRepository::class);
        $this->app->bind(CartSessionRepositoryContract::class, CartSessionRepository::class);
        $this->app->bind(CartItemContract::class, CartItem::class);
        $this->app->bind(CartItemRepositoryContract::class, CartItemRepository::class);
        $this->app->bind(UuidFactoryInterface::class, UuidFactory::class);

        $this->app->when(CartItem::class)
            ->needs('$id')
            ->give(1);

        $this->app->when(CartItem::class)
            ->needs('$name')
            ->give('Foo');

        $this->app->when(CartItem::class)
            ->needs('$price')
            ->give(1.00);

        $this->mergeConfigFrom(
            __DIR__ . '/Config/cart.php',
            'velkart.cart'
        );
    }
}
