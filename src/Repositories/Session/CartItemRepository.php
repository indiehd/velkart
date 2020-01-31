<?php

namespace IndieHD\Velkart\Repositories\Session;

use Gloudemans\Shoppingcart\Cart;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\CartItemContract;
use IndieHD\Velkart\Contracts\CartItemRepositoryContract;

class CartItemRepository implements CartItemRepositoryContract
{
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /*
    public function make($attributes): CartItemContract
    {
        $item = app()->make(CartItemContract::class, [
            'id' => $attributes['id'],
            'name' => $attributes['name'],
            'price' => $attributes['price'],
        ]);

        $item->setQuantity(1);

        return $item;
    }
    */

    public function create($attributes): CartItem
    {
        $item = app()->make(CartItemContract::class, [
            'id' => $attributes['id'],
            'name' => $attributes['name'],
            'price' => $attributes['price'],
        ]);

        $item->setQuantity(1);

        return $this->cart->add($item->toArray());
    }

    public function update($rowId, $quantity): CartItem
    {
        return $this->cart->update($rowId, $quantity);
    }

    public function remove($rowId): void
    {
        $this->cart->remove($rowId);
    }
}
