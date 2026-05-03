<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'storeys' => ['nullable', 'integer', 'min:1', 'max:255'],
            'garages' => ['nullable', 'integer', 'min:0', 'max:255'],
            'price_min' => ['nullable', 'numeric', 'min:0', 'max:99999999999.99'],
            'price_max' => ['nullable', 'numeric', 'min:0', 'max:99999999999.99'],
        ]);

        $properties = Property::query()
            ->when($filters['name'] ?? null, function ($query, $name) {
                $query->where('name', 'like', '%'.$name.'%');
            })
            ->when($filters['bedrooms'] ?? null, function ($query, $bedrooms) {
                $query->where('bedrooms', $bedrooms);
            })
            ->when($filters['bathrooms'] ?? null, function ($query, $bathrooms) {
                $query->where('bathrooms', $bathrooms);
            })
            ->when($filters['storeys'] ?? null, function ($query, $storeys) {
                $query->where('storeys', $storeys);
            })
            ->when($filters['garages'] ?? null, function ($query, $garages) {
                $query->where('garages', $garages);
            })
            ->when($filters['price_min'] ?? null, function ($query, $priceMin) {
                $query->where('price', '>=', $priceMin);
            })
            ->when($filters['price_max'] ?? null, function ($query, $priceMax) {
                $query->where('price', '<=', $priceMax);
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('properties.index', [
            'properties' => $properties,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('properties.create', [
            'property' => new Property(),
        ]);
    }

    public function store(StorePropertyRequest $request): RedirectResponse
    {
        $property = Property::query()->create($this->validatedData($request->validated()));

        return redirect()
            ->route('properties.show', $property)
            ->with('status', 'Property created successfully.');
    }

    public function show(Property $property): View
    {
        return view('properties.show', [
            'property' => $property,
        ]);
    }

    public function edit(Property $property): View
    {
        return view('properties.edit', [
            'property' => $property,
        ]);
    }

    public function update(UpdatePropertyRequest $request, Property $property): RedirectResponse
    {
        $property->update($this->validatedData($request->validated()));

        return redirect()
            ->route('properties.show', $property)
            ->with('status', 'Property updated successfully.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->delete();

        return redirect()
            ->route('properties.index')
            ->with('status', 'Property deleted successfully.');
    }

    /**
     * @param array<string, mixed> $validated
     * @return array<string, mixed>
     */
    protected function validatedData(array $validated): array
    {
        $validated['is_test'] = (bool) ($validated['is_test'] ?? false);

        return $validated;
    }
}
