<?php

namespace IndieHD\Velkart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\ProductRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\ProductImage;

class ProductImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = static::factoryForModel(resolve(ProductRepositoryContract::class)->modelClass());

        $file = UploadedFile::fake()->image($this->faker->word.'.jpg', 600, 600);

        return [
            'product_id' => $product,
            'disk'       => 'public',
            'path'       => $file->store('products', ['disk' => 'public']),
        ];
    }
}
