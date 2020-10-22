<?php

namespace IndieHD\Velkart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use IndieHD\Velkart\Models\Eloquent\Attribute;
use IndieHD\Velkart\Models\Eloquent\AttributeValue;

class AttributeValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttributeValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $attribute = Attribute::factory()->create();

        return [
            'attribute_id' => $attribute->id,
            'value'        => $this->faker->words($this->faker->numberBetween(1, 3), true),
        ];
    }
}
