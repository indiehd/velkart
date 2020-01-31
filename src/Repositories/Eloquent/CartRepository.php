<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Gloudemans\Shoppingcart\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\CartItemRepositoryContract;
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
     * @var CartItemRepositoryContract
     */
    protected $cartItem;

    /**
     * @param CartModel $cartModel
     * @param Cart $cart
     * @param CartItemRepositoryContract $cartItem
     */
    public function __construct(
        CartModel $cartModel,
        Cart $cart,
        CartItemRepositoryContract $cartItem
    ) {
        $this->cartModel = $cartModel;

        $this->cart = $cart;

        $this->cartItem = $cartItem;
    }

    public function modelClass(): string
    {
        return CartModel::class;
    }

    public function model(): Model
    {
        return $this->cartModel;
    }

    public function all(string $order = 'id', string $sort = 'desc', array $columns = ['*']): iterable
    {
        return $this->model()->orderBy($order, $sort)->get($columns);
    }

    public function findById($id): CartModel
    {
        return $this->cartModel->findOrFail($id);
    }

    public function findByIdentifier(string $identifier): Collection
    {
        $this->cart->restore($identifier);

        return $this->cart->content();
    }

    public function create(string $identifier): void
    {
        $this->cart->store($identifier);
    }

    public function delete(string $identifier)
    {
        $this->cart->erase($identifier);
    }
}
