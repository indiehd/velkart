<?php

use IndieHD\Velkart\Contracts\OrderRepositoryContract;
use Ramsey\Uuid\Uuid;

$order = resolve(OrderRepositoryContract::class);

$factory->define($order->modelClass(), function (Faker\Generator $faker) {

    $reference = Uuid::uuid4();

    return [
        'reference' => $reference,
    ];

});
