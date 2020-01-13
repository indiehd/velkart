<?php

use IndieHD\Velkart\Models\Eloquent\Attribute;
use IndieHD\Velkart\Models\Eloquent\AttributeValue;

$factory->define(AttributeValue::class, function (Faker\Generator $faker) {

    $attribute = factory(Attribute::class)->create();

    return [
        'attribute_id' => $attribute->id,
        'value' => $faker->words($faker->numberBetween(1, 3), true)
    ];

});
