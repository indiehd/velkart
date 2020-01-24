<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Gloudemans\Shoppingcart\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\CartItemContract;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Cart as CartModel;

class CartRepository implements CartRepositoryContract
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
        return $this->model()->orderBy($order, $sort)->get($columns);
    }

    public function findByIdentifier(string $identifier): Collection
    {
        $this->cart->restore($identifier);

        return $this->cart->content();
    }

    /**
     * Create a new record
     *
     * @param string $identifier
     * @return void
     */
    public function create(string $identifier): void
    {
        $this->cart->store($identifier);
    }

    public function add(string $identifier, CartItemContract $item)
    {
        $this->cart->restore($identifier);

        $cartItem = $this->cart->add($item->toArray());

        $this->cart->store($identifier);

        // This destroys the Cart Items within the *session*. Failure to do this
        // before "switching Carts", that is, restoring a Cart, modifying the
        // Items therein, and then storing it , can cause non-obvious behavior.

        $this->cart->destroy();

        return $cartItem;
    }

    public function update(string $identifier, $items)
    {
        $this->cart->restore($identifier);

        foreach ($items as $rowId => $props) {
            $this->cart->update($rowId, $props);
        }

        return true;
    }

    /*
    public function remove()
    {

    }

    public function delete()
    {

    }
    */
}
