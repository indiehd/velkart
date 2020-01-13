<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\DatabaseManager;
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
     * @var DatabaseManager
     */
    protected $db;

    /**
     * OrderRepository constructor.
     * @param Order $order
     * @param DatabaseManager $db
     */
    public function __construct(Order $order, DatabaseManager $db)
    {
        $this->order = $order;
        $this->db = $db;
    }

    public function modelClass(): string
    {
        return Order::class;
    }

    public function model(): Model
    {
        return $this->order;
    }

    public function delete(int $id): bool
    {
        $this->db->beginTransaction();

        try {
            $model = $this->findById($id);

            $model->delete();
        } catch (\Exception $e) {
            $this->db->rollBack();

            return false;
        }

        $this->db->commit();

        return true;
    }
}
