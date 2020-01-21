<?php

use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\CartRepositoryContract;
use Ramsey\Uuid\Uuid;

$cartRepository = resolve(CartRepositoryContract::class);

$factory->define($cartRepository->modelClass(), function (Faker\Generator $faker) {

    $identifier = Uuid::uuid4();

    return [
        'identifier' => $identifier->toString(),
        'instance' => 'default',
        'content' => serialize(new Collection)
    ];
});
