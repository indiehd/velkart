<?php

namespace IndieHD\Velkart\Repositories\Session;

use Gloudemans\Shoppingcart\Cart;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\CartItemContract;
use IndieHD\Velkart\Contracts\CartItemRepositoryContract;
use IndieHD\Velkart\Contracts\CartSessionRepositoryContract;

class CartSessionRepository implements CartSessionRepositoryContract
{
    protected $cart;

    protected $cartItem;

    public function __construct(
        Cart $cart,
        CartItemRepositoryContract $cartItem
    ) {
        $this->cart = $cart;

        $this->cartItem = $cartItem;
    }

    public function all(): Collection
    {
        return $this->cart->content();
    }

    public function findById(string $rowId): CartItem
    {
        return $this->cart->get($rowId);
    }

    public function create(CartItemContract $item): CartItem
    {
        #$item = $this->cartItem->make($id, $name, $price);

        return $this->cartItem->add($item);
    }

    public function update($item): CartItem
    {
        return $this->cartItem->update($item->rowId, $item->qty);
    }

    public function remove($item): void
    {
        $this->cartItem->remove($item);
    }

    public function destroy(): void
    {
        $this->cart->destroy();
    }
}
