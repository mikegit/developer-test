<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            [
                'name' => 'Victoria Gardens',
                'price' => 374662,
                'bedrooms' => 4,
                'bathrooms' => 2,
                'storeys' => 2,
                'garages' => 2,
                'is_test' => false,
            ],
            [
                'name' => 'Xavier Ridge',
                'price' => 513268,
                'bedrooms' => 4,
                'bathrooms' => 2,
                'storeys' => 1,
                'garages' => 2,
                'is_test' => false,
            ],
            [
                'name' => 'Como Retreat',
                'price' => 454990,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'storeys' => 2,
                'garages' => 3,
                'is_test' => false,
            ],
            [
                'name' => 'Aspen Grove',
                'price' => 384356,
                'bedrooms' => 4,
                'bathrooms' => 2,
                'storeys' => 2,
                'garages' => 2,
                'is_test' => false,
            ],
            [
                'name' => 'Lucretia Vale',
                'price' => 572002,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'storeys' => 2,
                'garages' => 2,
                'is_test' => false,
            ],
            [
                'name' => 'Toorak Heights',
                'price' => 521951,
                'bedrooms' => 5,
                'bathrooms' => 2,
                'storeys' => 1,
                'garages' => 2,
                'is_test' => false,
            ],
            [
                'name' => 'Skyscape Residences',
                'price' => 263604,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'storeys' => 2,
                'garages' => 2,
                'is_test' => false,
            ],
            [
                'name' => 'Clifton Park',
                'price' => 386103,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'storeys' => 1,
                'garages' => 1,
                'is_test' => false,
            ],
            [
                'name' => 'Geneva House',
                'price' => 390600,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'storeys' => 2,
                'garages' => 2,
                'is_test' => false,
            ],
        ];

        foreach ($properties as $property) {
            Property::query()->updateOrCreate(
                ['name' => $property['name']],
                $property
            );
        }

        $existingTestCount = Property::query()->where('is_test', true)->count();
        $missingTestCount = max(0, 50 - $existingTestCount);

        if ($missingTestCount > 0) {
            Property::factory()->count($missingTestCount)->create();
        }
    }
}
