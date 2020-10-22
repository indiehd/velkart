<?php

namespace IndieHD\Velkart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use IndieHD\Velkart\Models\Eloquent\Order;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderStatusRepositoryContract;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $orderStatus = resolve(OrderStatusRepositoryContract::class);

        return [
            'order_status_id' => $orderStatus->factory()->create()->id,
        ];
    }
}
