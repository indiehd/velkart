<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\ShoppingCartRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\ShoppingCart;

class ShoppingCartRepository extends BaseRepository implements ShoppingCartRepositoryContract
{
    /**
     * @var ShoppingCart
     */
    protected $shoppingCart;

    /**
     * ShoppingCart constructor.
     * @param ShoppingCart $shoppingCart
     */
    public function __construct(ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }

    public function modelClass(): string
    {
        return ShoppingCart::class;
    }

    public function model(): Model
    {
        return $this->shoppingCart;
    }
}
