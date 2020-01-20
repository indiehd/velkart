<?php

use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use IndieHD\Velkart\Contracts\ShoppingCartRepositoryContract;

$order = resolve(OrderRepositoryContract::class);
$cart = resolve(ShoppingCartRepositoryContract::class);

$factory->define($order->modelClass(), function (Faker\Generator $faker) use ($cart) {

    return [
        'shopping_cart_id' => factory($cart->modelClass())->create()->id,
    ];

});
