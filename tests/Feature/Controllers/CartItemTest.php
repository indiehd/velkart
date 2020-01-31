<?php

namespace Tests\Integration;

use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\CartItemRepositoryContract;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use IndieHD\Velkart\Contracts\CartSessionRepositoryContract;
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
    public function itCanListItems()
    {
        #$cartItem1 = $this->cartItem->make(1, 'Foo', 1.00);

        $cartItem1 = $this->cartItem->create(['id' => 1, 'name' => 'Foo', 'price' => 1.00]);

        #$cartItem2 = $this->cartItem->make(2, 'Bar', 1.00);

        $cartItem2 = $this->cartItem->create(['id' => 2, 'name' => 'Bar', 'price' => 1.00]);

        $this->getJson(
            route('cart.list')
        )
        ->assertStatus(200)
        ->assertJsonFragment($cartItem1->toArray())
        ->assertJsonFragment($cartItem2->toArray());
    }

    /** @test */
    public function itCanStoreOneItem()
    {
        $item = ['id' => 1, 'name' => 'Foo', 'price' => 1.00];

        $this->postJson(
            route('cart.store'),
            $item
        )
        ->assertStatus(200)
        ->assertJsonFragment($item);
    }

    /** @test */
    public function itCanUpdateOneItem()
    {
        #$cartItem = $this->cartItem->make(1, 'Foo', 1.00);

        $cartItem = $this->cartItem->create(['id' => 1, 'name' => 'Foo', 'price' => 1.00]);

        $this->postJson(
            route('cart.update', [
                'data' => json_encode(['rowId' => $cartItem->rowId, 'qty' => 2])
            ])
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
        $cartItem = $this->cartItem->make(1, 'Foo', 1.00);

        $this->cartItem->create($cartItem);

        $this->postJson(
            route('cart.delete', [
                'data' => json_encode($cartItem->rowId)
            ])
        )
        ->assertStatus(200);
    }

    public function itCanStoreManyItems()
    {

    }

    public function itCanUpdateManyItems()
    {

    }

    public function itCanRemoveManyItems()
    {

    }
}
