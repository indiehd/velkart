<?php

namespace Tests\Integration;

use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CartRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartItemRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartSessionRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;

class CartTest extends TestCase
{
    /**
     * @var CartSessionRepositoryContract
     */
    protected $cartSession;

    /**
     * @var CartItemRepositoryContract
     */
    protected $cartItem;

    /**
     * {@inheritdoc}
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
    public function itCanStore()
    {
        $this->postJson(
            route('cart.store'),
            ['identifier' => 'foo']
        )
            ->assertStatus(200)
            ->assertJsonFragment([
                'identifier' => 'foo',
                'content'    => [],
            ]);
    }

    /** @test */
    public function itCanListManyCartsWithItems()
    {
        $carts = $this->cart->factory()->count(2)->create();

        $cartItems = new Collection();

        foreach ($carts as $cart) {
            $cart->delete($cart->identifier);

            // Pass the Cart ID for the Item ID argument because it's unique
            // within this loop, which enables us to test for unique row ID
            // hashes for each Item that is added to the cart.

            $cartItem = $this->cartItem->create($cart->id, 'Foo', 1.00);

            $cartItems->push($cartItem);

            $this->cart->create($cart->identifier);

            $this->cartSession->destroy();
        }

        // Ensure that the two Cart identifiers are present, as well as the
        // item (row) ID for the Cart Item in each respective Cart.

        $this->getJson(route('cart.all'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'identifier' => $carts->get(0)->identifier,
            ])
            ->assertJsonFragment([
                'identifier' => $carts->get(1)->identifier,
            ])
            ->assertJsonFragment([
                'rowId' => $cartItems->get(0)->rowId,
            ])
            ->assertJsonFragment([
                'rowId' => $cartItems->get(1)->rowId,
            ]);
    }

    /** @test */
    public function itCanListCartByIdentifier()
    {
        $cart = $this->cart->factory()->create();

        // The cart will be empty (i.e., it will have no items), and hence the
        // empty JSON fragment.

        $this->getJson(
            route('cart.show', ['identifier' => $cart->identifier])
        )
            ->assertStatus(200)
            ->assertJsonFragment([
                'identifier' => $cart->identifier,
            ])
            ->assertJsonFragment([
                'content' => [],
            ]);
    }

    /** @test */
    public function itCanDestroy()
    {
        $cart = $this->cart->factory()->create();

        $this->deleteJson(
            route('cart.delete', ['identifier' => $cart->identifier])
        )
            ->assertStatus(200);
    }
}
