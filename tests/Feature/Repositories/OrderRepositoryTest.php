<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Illuminate\Database\Eloquent\Collection;
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
        $order = factory($this->getRepository()->modelClass())->create();

        $status = factory($this->orderStatus->modelClass())->create();

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
        $order = factory($this->getRepository()->modelClass())->create();

        $products = factory($this->product->modelClass(), 2)->create();

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
