<?php

use IndieHD\Velkart\Models\Eloquent\Order;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

$factory->define(Order::class, function (Faker\Generator $faker) {

    $reference = Uuid::uuid4();

    return [
        'reference' => $reference,
    ];

});
