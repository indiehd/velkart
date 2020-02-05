<?php

use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CartRepositoryContract;
use Ramsey\Uuid\UuidFactoryInterface;

$cartRepository = resolve(CartRepositoryContract::class);
$uuidFactory = resolve(UuidFactoryInterface::class);

$factory->define($cartRepository->modelClass(), function (Faker\Generator $faker) use ($uuidFactory) {

    $identifier = $uuidFactory->uuid4();

    return [
        'identifier' => $identifier->toString(),
        'instance' => 'default',
        'content' => serialize(new Collection)
    ];
});
