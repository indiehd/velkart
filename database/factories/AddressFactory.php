<?php

use IndieHD\Velkart\Contracts\Repositories\Eloquent\AddressRepositoryContract;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CountryRepositoryContract;

$address = resolve(AddressRepositoryContract::class);
$country = resolve(CountryRepositoryContract::class);

$factory->define($address->modelClass(), function (Faker\Generator $faker) {

    return [
        'alias' => $faker->randomElement(['Home', 'Work', 'School']),
        'address_1' => $faker->streetAddress,
        'country_id' => 1,
    ];

});

$factory->state($address->modelClass(), 'withCountry', [
    'country_id' => function() use ($country) {
        return factory($country->modelClass())->create()->id;
    }
]);
