<?php

use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Collection;
use IndieHD\Velkart\Contracts\ShoppingCartRepositoryContract;
use Ramsey\Uuid\Uuid;

$cart = resolve(Cart::class);
$cartRepository = resolve(ShoppingCartRepositoryContract::class);

$factory->define($cartRepository->modelClass(), function (Faker\Generator $faker) use ($cart) {

    $identifier = Uuid::uuid4();

    return [
        'identifier' => $identifier->toString(),
        'instance' => 'default',
        'content' => serialize(new Collection)
    ];
});
