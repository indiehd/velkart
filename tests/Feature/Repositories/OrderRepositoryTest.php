<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Illuminate\Database\Eloquent\Collection;
use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\ProductRepositoryContract;
use IndieHD\Velkart\Contracts\CartRepositoryContract;

class OrderRepositoryTest extends RepositoryTestCase
{
    /**
     * @var ProductRepositoryContract
     */
    protected $product;

    /**
     * @var CartRepositoryContract
     */
    protected $cart;

    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(OrderRepositoryContract::class));

        $this->product = resolve(ProductRepositoryContract::class);
        $this->cart = resolve(CartRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdate()
    {
        $order = factory($this->getRepository()->modelClass())->create();

        $cart = factory($this->cart->modelClass())->create();

        $updates = [
            'cart_id' => $cart->id,
        ];

        $updated = $this->getRepository()->update($order->id, $updates);

        $this->assertTrue($updated);
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), $updates);
    }

    /** @test */
    public function itHasManyProducts()
    {
        $order = factory($this->getRepository()->modelClass())->create();

        $products = factory($this->product->modelClass(), 2)->make();

        $order->products()->saveMany($products);

        $this->assertInstanceOf(Collection::class, $order->products);

        $this->assertInstanceOf(
            $this->product->modelClass(),
            $order->products->first()
        );
    }

    /** @test */
    public function itBelongsToShoppingCart()
    {
        $order = factory($this->getRepository()->modelClass())->create();

        $this->assertInstanceOf(
            $this->cart->modelClass(),
            $order->cart
        );
    }
}
