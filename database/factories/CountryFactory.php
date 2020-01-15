<?php

use IndieHD\Velkart\Contracts\CountryRepositoryContract;

$country = resolve(CountryRepositoryContract::class);

$factory->define($country->modelClass(), function (Faker\Generator $faker) {

    return [
        'name' => $faker->words(2, true),
        'code' => $faker->unique()->toUpper(
            $faker->randomLetter
            . $faker->randomLetter
            . $faker->randomLetter
        )
    ];

});
