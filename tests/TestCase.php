<?php

namespace IndieHD\Velkart\Tests;

use Faker\Factory;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use IndieHD\Velkart\Category\Category;
use IndieHD\Velkart\Product\Product;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    use DatabaseMigrations, DatabaseTransactions;

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

        $this->faker = Factory::create();

        $this->product = factory(Product::class)->create();
        $this->category = factory(Category::class)->create();

        $session = $this->app->make('session');
        $events = $this->app->make('events');

        $this->cart = new Cart($session, $events);
    }

}
