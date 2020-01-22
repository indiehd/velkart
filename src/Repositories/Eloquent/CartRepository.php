<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Cart;

class CartRepository extends BaseRepository implements CartRepositoryContract
{
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * Cart constructor.
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function modelClass(): string
    {
        return Cart::class;
    }

    public function model(): Model
    {
        return $this->cart;
    }
}
