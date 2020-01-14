<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use Illuminate\Database\Eloquent\Collection;
use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\ProductRepositoryContract;
use Ramsey\Uuid\Uuid;

class OrderRepositoryTest extends RepositoryTestCase
{
    protected $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->repo = resolve(OrderRepositoryContract::class);
        $this->product = resolve(ProductRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdate()
    {
        $order = factory($this->getRepository()->modelClass())->create();

        $reference = Uuid::uuid4();

        $updates = [
            'reference' => $reference
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


}
