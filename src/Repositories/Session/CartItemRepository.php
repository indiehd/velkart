<?php

namespace IndieHD\Velkart\Repositories\Session;

use IndieHD\Velkart\Contracts\CartItemContract;
use IndieHD\Velkart\Contracts\CartItemRepositoryContract;

class CartItemRepository implements CartItemRepositoryContract
{
    public function make($id, $name, $price): CartItemContract
    {
        return app()->make(CartItemContract::class, [
            'id' => $id,
            'name' => $name,
            'price' => $price,
        ]);
    }
}
