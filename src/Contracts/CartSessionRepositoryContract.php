<?php

namespace IndieHD\Velkart\Contracts;

use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Support\Collection;

interface CartSessionRepositoryContract
{
    public function all(): Collection;

    public function findById(string $rowId): CartItem;

    /**
     * @param $attributes
     * @return CartItem
     */
    public function create(CartItemContract $item): CartItem;

    public function update($item): CartItem;

    public function remove($item): void;

    public function destroy(): void;
}
