<?php

namespace IndieHD\Velkart\Contracts\Repositories\Session;

use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Support\Collection;

interface CartItemRepositoryContract
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param $id
     * @return CartItem
     */
    public function findById($id): CartItem;

    /**
     * @param $id
     * @param string $name
     * @param $price
     * @return CartItem
     */
    public function create($id, string $name, $price): CartItem;

    /**
     * @param $rowId
     * @param $props
     * @return mixed
     */
    public function update($rowId, $props);

    /**
     * @param $rowId
     */
    public function destroy($rowId): void;
}
