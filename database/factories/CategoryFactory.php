<?php

namespace IndieHD\Velkart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use IndieHD\Velkart\Models\Eloquent\Category;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->words(3, true);
        $slug = Str::slug($name);

        return [
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->faker->paragraph,
            'cover'       => $this->faker->imageUrl(),
            'status'      => $this->faker->numberBetween(0, 1), // 0 inactive; 1 active;
        ];
    }
}
