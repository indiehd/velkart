<?php

namespace IndieHD\Velkart\Cart;

use Gloudemans\Shoppingcart\CartItem as CartItemBase;
use IndieHD\Velkart\Contracts\CartItemContract;

class CartItem extends CartItemBase implements CartItemContract
{
    public function __construct($id, $name, $price)
    {
        parent::__construct($id, $name, $price);
    }
}
