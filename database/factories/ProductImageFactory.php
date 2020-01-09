<?php

use Illuminate\Http\UploadedFile;
use IndieHD\Velkart\Models\Eloquent\Product;
use IndieHD\Velkart\Models\Eloquent\ProductImage;

$factory->define(ProductImage::class, function (Faker\Generator $faker) {

    $product = factory(Product::class)->create();
    $file = UploadedFile::fake()->image($faker->word . '.jpg', 600, 600);

    return [
        'product_id' => $product->id,
        'src' => $file->store('products', ['disk' => 'public'])
    ];

});
