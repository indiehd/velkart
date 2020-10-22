<?php

use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderStatusRepositoryContract;

$order = resolve(OrderRepositoryContract::class);
$orderStatus = resolve(OrderStatusRepositoryContract::class);

$factory->define($order->modelClass(), function (Faker\Generator $faker) use ($orderStatus) {
    return [
        'order_status_id' => factory($orderStatus->modelClass())->create()->id,
    ];
});
