<?php

namespace IndieHD\Velkart\Repositories\Session;

use Gloudemans\Shoppingcart\Cart;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\Models\CartItemContract;
use IndieHD\Velkart\Contracts\Repositories\Session\CartItemRepositoryContract;

class CartItemRepository implements CartItemRepositoryContract
{
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function all(): Collection
    {
        return $this->cart->content();
    }

    public function findById($id): CartItem
    {
        return $this->cart->get($id);
    }

    public function create($id, string $name, $price): CartItem
    {
        $item = app()->make(CartItemContract::class, [
            'id' => $id,
            'name' => $name,
            'price' => $price,
        ]);

        $item->setQuantity(1);

        return $this->cart->add($item->toArray());
    }

    public function update($rowId, $quantity): CartItem
    {
        return $this->cart->update($rowId, $quantity);
    }

    public function destroy($rowId): void
    {
        $this->cart->remove($rowId);
    }
}
