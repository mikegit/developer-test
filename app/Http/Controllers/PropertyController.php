<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use App\Support\JsendResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate($this->filterRules());

        $properties = Property::query()
            ->filter($filters)
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('properties.index', [
            'properties' => $properties,
            'filters' => $filters,
        ]);
    }

    public function vueIndex(Request $request): View
    {
        $filters = $request->validate($this->filterRules());

        return view('properties.index-vue', [
            'appData' => [
                'filters' => $filters,
                'searchUrl' => route('properties.search'),
                'createUrl' => route('properties.create'),
                'indexUrl' => route('properties.index'),
                'showUrlTemplate' => route('properties.show', ['property' => '__PROPERTY_ID__']),
                'editUrlTemplate' => route('properties.edit', ['property' => '__PROPERTY_ID__']),
            ],
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $filters = $request->validate($this->filterRules());

        $properties = Property::query()
            ->filter($filters)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'price',
                'bedrooms',
                'bathrooms',
                'storeys',
                'garages',
                'is_test',
            ]);

        return JsendResponse::success('Properties fetched successfully.', [
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

    /**
     * @return array<string, array<int, string>>
     */
    protected function filterRules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'storeys' => ['nullable', 'integer', 'min:1', 'max:255'],
            'garages' => ['nullable', 'integer', 'min:0', 'max:255'],
            'price_min' => ['nullable', 'numeric', 'min:0', 'max:99999999999.99'],
            'price_max' => ['nullable', 'numeric', 'min:0', 'max:99999999999.99'],
        ];
    }
}
