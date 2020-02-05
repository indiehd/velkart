<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderStatusRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\OrderStatus;

class OrderStatusRepository extends BaseRepository implements OrderStatusRepositoryContract
{
    /**
     * @var OrderStatus
     */
    protected $orderStatus;

    /**
     * OrderStatusRepository constructor.
     * @param OrderStatus $orderStatus
     */
    public function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

    public function modelClass(): string
    {
        return OrderStatus::class;
    }

    public function model(): Model
    {
        return $this->orderStatus;
    }
}
