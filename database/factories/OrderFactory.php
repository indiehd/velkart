<?php

use IndieHD\Velkart\Contracts\Repositories\Eloquent\CartRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\OrderRepositoryContract;

$order = resolve(OrderRepositoryContract::class);
$cart = resolve(CartRepositoryContract::class);

$factory->define($order->modelClass(), function (Faker\Generator $faker) use ($cart) {

    return [
        'cart_id' => factory($cart->modelClass())->create()->id,
    ];

});
