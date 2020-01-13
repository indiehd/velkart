<?php

use IndieHD\Velkart\Models\Eloquent\Attribute;

$factory->define(Attribute::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->unique()->word
    ];

});
