<?php

use IndieHD\Velkart\Category\Category;

$factory->define(Category::class, function (Faker\Generator $faker) {

    $name = $faker->unique()->words(3, true);
    $slug = str_slug($name);

    return [
        'name' => $name,
        'slug' => $slug,
        'description' => $faker->paragraph,
        'cover' => $faker->imageUrl(),
        'status' => $faker->numberBetween(0, 1) // 0 inactive; 1 active;
    ];

});
