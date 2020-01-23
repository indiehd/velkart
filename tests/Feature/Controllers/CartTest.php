<?php

namespace Tests\Integration;

use IndieHD\Velkart\Contracts\CartRepositoryContract;
use IndieHD\Velkart\Tests\TestCase;

class CartTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->cart = resolve(CartRepositoryContract::class);
    }

    /** @test */
    public function itCanRetrieveAllCarts()
    {
        $carts = factory($this->cart->modelClass(), 2)->create()
            ->sortBy('identifier');

        $this->get(route('cart.index'))
            ->assertStatus(200)
            ->assertExactJson([
                'data' => [
                    $carts->shift()->identifier => [],
                    $carts->shift()->identifier => [],
                ]
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
