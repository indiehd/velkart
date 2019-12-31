<?php

namespace IndieHD\Velkart\Tests;

use Faker\Factory;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use IndieHD\Velkart\Category\Category;
use IndieHD\Velkart\Product\Product;
use IndieHD\Velkart\VelkartServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    protected $faker;
    protected $product;
    protected $category;
    protected $cart;

    /**
     * Set up the test
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/../database/factories');

        $this->faker = Factory::create();

        $this->product = factory(Product::class)->create();
        $this->category = factory(Category::class)->create();

        $session = $this->app->make('session');
        $events = $this->app->make('events');

        $this->cart = new Cart($session, $events);
    }

    protected function getPackageProviders($app)
    {
        return [
            VelkartServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}
