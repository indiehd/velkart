<?php

namespace IndieHD\Velkart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CountryRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Address;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'alias'      => $this->faker->randomElement(['Home', 'Work', 'School']),
            'address_1'  => $this->faker->streetAddress,
            'country_id' => 1,
        ];
    }

    public function withCountry()
    {
        return $this->state(function () {
            return [
                'country_id' => resolve(CountryRepositoryContract::class)->factory()->create()->id,
            ];
        });
    }
}
