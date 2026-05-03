<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_property_index(): void
    {
        $user = User::factory()->create();
        Property::factory()->count(3)->create();

        $response = $this
            ->actingAs($user)
            ->get(route('properties.index'));

        $response->assertOk();
        $response->assertSee('Properties');
        $response->assertSee('Server-rendered property listing and search.');
    }

    public function test_authenticated_user_can_view_vue_property_index(): void
    {
        $user = User::factory()->create();
        Property::factory()->count(3)->create();

        $response = $this
            ->actingAs($user)
            ->get(route('properties.vue-index'));

        $response->assertOk();
        $response->assertSee('Properties Vue');
        $response->assertSee('propertyApp');
    }

    public function test_authenticated_user_can_create_property(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('properties.store'), [
                'name' => 'Harbour View Estate',
                'price' => '649500.00',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'storeys' => 2,
                'garages' => 2,
                'is_test' => 0,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', [
            'name' => 'Harbour View Estate',
            'is_test' => 0,
        ]);
    }

    public function test_authenticated_user_can_filter_properties_by_partial_name_and_price_range(): void
    {
        $user = User::factory()->create();

        Property::factory()->create([
            'name' => 'Victoria Gardens',
            'price' => 374662.00,
        ]);

        Property::factory()->create([
            'name' => 'Victoria Ridge',
            'price' => 610000.00,
        ]);

        Property::factory()->create([
            'name' => 'Harbour View Estate',
            'price' => 374662.00,
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson(route('properties.search', [
                'name' => 'Victoria',
                'price_min' => 300000,
                'price_max' => 500000,
            ]));

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonCount(1, 'data.properties');
        $response->assertJsonPath('data.properties.0.name', 'Victoria Gardens');
    }

    public function test_authenticated_user_can_filter_properties_by_exact_numeric_fields(): void
    {
        $user = User::factory()->create();

        Property::factory()->create([
            'name' => 'Harbour Springs',
            'bedrooms' => 4,
            'bathrooms' => 2,
            'storeys' => 2,
            'garages' => 1,
        ]);

        Property::factory()->create([
            'name' => 'Harbour Heights',
            'bedrooms' => 5,
            'bathrooms' => 3,
            'storeys' => 1,
            'garages' => 2,
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson(route('properties.search', [
                'bedrooms' => 4,
                'bathrooms' => 2,
                'storeys' => 2,
                'garages' => 1,
            ]));

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonCount(1, 'data.properties');
        $response->assertJsonPath('data.properties.0.name', 'Harbour Springs');
    }

    public function test_authenticated_user_can_update_property(): void
    {
        $user = User::factory()->create();
        $property = Property::factory()->create([
            'name' => 'Coastal Rise',
            'is_test' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('properties.update', $property), [
                'name' => 'Coastal Rise Renovated',
                'price' => '715000.00',
                'bedrooms' => 5,
                'bathrooms' => 3,
                'storeys' => 2,
                'garages' => 2,
                'is_test' => 1,
            ]);

        $response->assertRedirect(route('properties.show', $property));
        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'name' => 'Coastal Rise Renovated',
            'bedrooms' => 5,
        ]);
    }

    public function test_authenticated_user_can_delete_property(): void
    {
        $user = User::factory()->create();
        $property = Property::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('properties.destroy', $property));

        $response->assertRedirect(route('properties.index'));
        $this->assertDatabaseMissing('properties', [
            'id' => $property->id,
        ]);
    }
}
