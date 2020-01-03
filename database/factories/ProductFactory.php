<?php

use IndieHD\Velkart\Product\Product;
use Illuminate\Http\UploadedFile;

$factory->define(Product::class, function (Faker\Generator $faker) {

    $product = 'Samsung Galaxy S10';

    return [
        'sku' => $this->faker->unique()->numberBetween(1111111, 999999),
        'name' => $product,
        'slug' => str_slug($product),
        'description' => $this->faker->paragraph,
        'cover' => UploadedFile::fake()->image('product.png', 600, 600),
        'quantity' => 10,
        'price' => 9.95,
        'status' => 1,
    ];

});
