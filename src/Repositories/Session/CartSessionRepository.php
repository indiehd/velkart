<?php

namespace IndieHD\Velkart\Repositories\Session;

use Gloudemans\Shoppingcart\Cart;
use IndieHD\Velkart\Contracts\Repositories\Session\CartSessionRepositoryContract;

class CartSessionRepository implements CartSessionRepositoryContract
{
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * CartSessionRepository constructor.
     * @param Cart $cart
     */
    public function __construct(
        Cart $cart
    ) {
        $this->cart = $cart;
    }

    public function destroy(): void
    {
        $this->cart->destroy();
    }
}
