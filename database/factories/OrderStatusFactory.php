<?php

use IndieHD\Velkart\Contracts\OrderStatusRepositoryContract;

$orderStatus = resolve(OrderStatusRepositoryContract::class);

$factory->define($orderStatus->modelClass(), function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
    ];

});
