<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use Faker\Generator;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    protected ?Generator $fakerEnAu = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->fakerEnAu ??= FakerFactory::create('en_AU');

        return [
            'name' => $faker->unique()->streetName().' Residence',
            'price' => $faker->numberBetween(250000, 950000),
            'bedrooms' => $faker->numberBetween(2, 6),
            'bathrooms' => $faker->numberBetween(1, 4),
            'storeys' => $faker->numberBetween(1, 3),
            'garages' => $faker->numberBetween(0, 3),
            'is_test' => true,
        ];
    }
}
