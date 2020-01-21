<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Order;

class OrderRepository extends BaseRepository implements OrderRepositoryContract
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function modelClass(): string
    {
        return Order::class;
    }

    public function model(): Model
    {
        return $this->order;
    }
}
