<?php

namespace Tests\Integration;

use IndieHD\Velkart\Contracts\Repositories\Eloquent\CartRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartItemRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartSessionRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;

class CartItemTest extends TestCase
{
    /**
     * @var CartRepositoryContract
     */
    protected $cart;

    /**
     * @var CartSessionRepositoryContract
     */
    protected $cartSession;

    /**
     * @var CartItemRepositoryContract
     */
    protected $cartItem;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->cart = resolve(CartRepositoryContract::class);

        $this->cartSession = resolve(CartSessionRepositoryContract::class);

        $this->cartItem = resolve(CartItemRepositoryContract::class);
    }

    /** @test */
    public function itCanStoreOneItem()
    {
        $item = ['id' => 1, 'name' => 'Foo', 'price' => 1.00];

        $this->postJson(
            route('item.store'),
            $item
        )
        ->assertStatus(200)
        ->assertJsonFragment($item);
    }

    /** @test */
    public function itCanUpdateOneItem()
    {
        $cartItem = $this->cartItem->create(1, 'Foo', 1.00);

        $this->postJson(
            route('item.update'),
            ['rowId' => $cartItem->rowId, 'qty' => 2]
        )
        ->assertStatus(200)
        ->assertJsonFragment([
            'rowId' => $cartItem->rowId,
            'qty' => 2
        ]);
    }

    /** @test */
    public function itCanRemoveOneItem()
    {
        $cartItem = $this->cartItem->create(1, 'Foo', 1.00);

        $this->postJson(
            route('item.delete'),
            ['rowId' => $cartItem->rowId]
        )
        ->assertStatus(200);
    }

    /** @test */
    public function itCanListOneItem()
    {
        $item = $this->cartItem->create(1, 'Foo', 1.00);

        $this->getJson(
            route('item.show', ['id' => $item->rowId])
        )
        ->assertStatus(200)
        ->assertJsonFragment(['rowId' => $item->rowId]);
    }

    public function itCanListManyItems()
    {
        $item1 = $this->cartItem->create(1, 'Foo', 1.00);

        $item2 = $this->cartItem->create(2, 'Bar', 1.00);

        $this->getJson(
            route('item.list')
        )
        ->assertStatus(200)
        ->assertJsonFragment(['rowId' => $item1->rowId])
        ->assertJsonFragment(['rowId' => $item2->rowId]);
    }
}
