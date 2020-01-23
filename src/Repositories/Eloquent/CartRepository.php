<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Gloudemans\Shoppingcart\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Cart as CartModel;

class CartRepository extends BaseRepository implements CartRepositoryContract
{
    /**
     * @var CartModel
     */
    protected $cartModel;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * CartRepository constructor.
     * @param CartModel $cartModel
     * @param Cart $cart
     */
    public function __construct(
        CartModel $cartModel,
        Cart $cart
    ) {
        $this->cartModel = $cartModel;

        $this->cart = $cart;
    }

    public function modelClass(): string
    {
        return CartModel::class;
    }

    public function model(): Model
    {
        return $this->cartModel;
    }

    /**
     * List all the records
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return iterable
     */
    public function list(string $order = 'id', string $sort = 'desc', array $columns = ['*']): iterable
    {
        $cartModels = $this->model()->orderBy($order, $sort)->get($columns);

        $cartCollection = new Collection();

        foreach ($cartModels as $cart) {
            $this->cart->restore($cart->identifier);

            $cartCollection->put($cart->identifier, $this->cart->content());
        }

        return $cartCollection;
    }

    public function findByIdentifier(string $identifier): string
    {
        $this->cart->restore($identifier);

        return $this->cart->content();
    }
}
