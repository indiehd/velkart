<?php

namespace IndieHD\Velkart\Contracts;

use Gloudemans\Shoppingcart\CartItem;

interface CartItemRepositoryContract
{
    #public function make($id, string $name, $price): CartItemContract;

    #public function create(CartItemContract $item): CartItem;

    #public function list(string $order = 'id', string $sort = 'desc', array $columns = ['*']): iterable;

    public function create(array $attributes): CartItem;

    public function update($rowId, $props);

    public function remove($rowId): void;

    #public function findById(int $id): object;
}
