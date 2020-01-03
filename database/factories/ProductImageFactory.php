<?php

use IndieHD\Velkart\ProductImage\ProductImage;
use Illuminate\Http\UploadedFile;
use IndieHD\Velkart\Product\Product;

$factory->define(ProductImage::class, function (Faker\Generator $faker) {

    $productId = factory(Product::class)->create();
    $file = UploadedFile::fake()->image($faker->word . '.jpg', 600, 600);

    return [
        'product_id' => $productId,
        'src' => $file->store('products', ['disk' => 'public'])
    ];

});
