<?php

use IndieHD\Velkart\Models\Eloquent\Category;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker\Generator $faker) {

    $name = $faker->unique()->words(3, true);
    $slug = Str::slug($name);

    return [
        'name' => $name,
        'slug' => $slug,
        'description' => $faker->paragraph,
        'cover' => $faker->imageUrl(),
        'status' => $faker->numberBetween(0, 1) // 0 inactive; 1 active;
    ];

});
