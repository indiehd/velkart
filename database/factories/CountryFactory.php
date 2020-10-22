<?php

namespace IndieHD\Velkart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use IndieHD\Velkart\Models\Eloquent\Country;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'code' => $this->faker->unique()->toUpper(
                $this->faker->randomLetter
                    . $this->faker->randomLetter
                    . $this->faker->randomLetter
            ),
        ];
    }
}
