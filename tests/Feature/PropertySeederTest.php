<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertySeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_seeder_loads_source_and_generated_records(): void
    {
        $this->seed();

        $this->assertDatabaseCount('properties', 59);
        $this->assertSame(9, Property::query()->where('is_test', false)->count());
        $this->assertSame(50, Property::query()->where('is_test', true)->count());

        $property = Property::query()->firstWhere('name', 'Victoria Gardens');

        $this->assertNotNull($property);
        $this->assertSame('374662.00', $property->price);
        $this->assertSame(4, $property->bedrooms);
        $this->assertFalse($property->is_test);
    }
}
