<?php

namespace IndieHD\Velkart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use IndieHD\Velkart\Models\Eloquent\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
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
    }
}
