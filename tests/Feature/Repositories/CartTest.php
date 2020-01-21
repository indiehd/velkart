<?php

namespace IndieHD\Velkart\Tests\Feature\Repositories;

use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use Ramsey\Uuid\Uuid;

class CartTest extends RepositoryTestCase
{
    /*
     * @var OrderRepositoryContract
     */
    protected $order;

    public function setUp(): void
    {
        parent::setUp();

        $this->setRepository(resolve(CartRepositoryContract::class));

        $this->order = resolve(OrderRepositoryContract::class);
    }

    /** @test */
    public function itCanUpdate()
    {
        $cart = factory($this->getRepository()->modelClass())->create();

        $identifier = Uuid::uuid4();

        $updates = [
            'identifier' => $identifier->toString()
        ];

        $updated = $this->getRepository()->update($cart->id, $updates);

        $this->assertTrue($updated);
        $this->assertDatabaseHas($this->getRepository()->model()->getTable(), $updates);
    }

    /** @test */
    public function itHasOneOrder()
    {
        $order = factory($this->order->modelClass())->create();

        $cart = $this->getRepository()->findById($order->cart->id);

        $this->assertInstanceOf(
            $this->order->modelClass(),
            $cart->order
        );
    }
}
