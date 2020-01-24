<?php

namespace Tests\Integration;

use IndieHD\Velkart\Contracts\CartItemContract;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use IndieHD\Velkart\Contracts\CartItemRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;
use Illuminate\Support\Collection;

class CartTest extends TestCase
{
    /**
     * @var CartRepositoryContract
     */
    protected $cart;

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

        $this->cartItem = resolve(CartItemRepositoryContract::class);
    }

    /** @test */
    public function itCanRetrieveManyCartsWithItems()
    {
        $carts = factory($this->cart->modelClass(), 2)->create();

        $cartItems = new Collection();

        foreach ($carts as $cart) {
            $cartItem = $this->cartItem->make($cart->id, 'Foo', 1.00);

            $cartItem->setQuantity(1);

            $cartItem = $this->cart->add(
                $cart->identifier,
                $cartItem
            );

            $cartItems->push($cartItem);
        }

        // Ensure that the two Cart identifiers are present, as well as the
        // item (row) ID for the Cart Item in each respective Cart.

        $this->get(route('cart.index'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'identifier' => $carts->get(0)->identifier,
            ])
            ->assertJsonFragment([
                'identifier' => $carts->get(1)->identifier
            ])
            ->assertJsonFragment([
                'rowId' => $cartItems->get(0)->rowId
            ])
            ->assertJsonFragment([
                'rowId' => $cartItems->get(1)->rowId
            ]);
    }

    /** @test */
    public function itCanRetrieveCartByIdentifier()
    {
        $cart = factory($this->cart->modelClass())->create();

        $this->getJson(
            route('cart.show', ['identifier' => $cart->identifier])
        )
        ->assertStatus(200)
        ->assertJsonFragment([]);
    }
}
