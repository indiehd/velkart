<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use IndieHD\Velkart\Models\Eloquent\Product;

$factory->define(Product::class, function (Faker\Generator $faker) {
    $product = 'Samsung Galaxy S10';

    return [
        'sku'         => $this->faker->unique()->numberBetween(1111111, 999999),
        'name'        => $product,
        'slug'        => Str::slug($product),
        'description' => $this->faker->paragraph,
        'cover'       => UploadedFile::fake()->image('product.png', 600, 600),
        'quantity'    => 10,
        'price'       => 9.95,
        'status'      => 1,
    ];
});
