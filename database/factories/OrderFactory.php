<?php

use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\CartRepositoryContract;

$order = resolve(OrderRepositoryContract::class);
$cart = resolve(CartRepositoryContract::class);

$factory->define($order->modelClass(), function (Faker\Generator $faker) use ($cart) {

    return [
        'cart_id' => factory($cart->modelClass())->create()->id,
    ];

});
