<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderStatusRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\ProductRepositoryContract;

class OrderRepositoryTest extends RepositoryTestCase
{
    /**
     * @var ProductRepositoryContract
     */
    protected $product;

    /**
     * @var OrderStatusRepositoryContract
     */
    protected $orderStatus;

    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(OrderRepositoryContract::class));

        $this->product = resolve(ProductRepositoryContract::class);
        $this->orderStatus = resolve(OrderStatusRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdate()
    {
        $order = $this->factory()->create();

        $status = $this->orderStatus->factory()->create();

        $updates = [
            'order_status_id' => $status->id,
        ];

        $updated = $this->getRepository()->update($order->id, $updates);

        $this->assertTrue($updated);
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), $updates);
    }

    /** @test */
    public function itHasManyProducts()
    {
        $order = $this->factory()->create();

        $products = $this->product->factory()->count(2)->make();

        $products->each(function ($product) use ($order) {
            $order->products()->attach($product->id, ['price' => $product->price]);
        });

        $this->assertInstanceOf(Collection::class, $order->products);

        $this->assertInstanceOf(
            $this->product->modelClass(),
            $order->products->first()
        );
    }
}
