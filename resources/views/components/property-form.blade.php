@php
    $propertyPrice = old('price', $property->price ? number_format((float) $property->price, 2, '.', '') : '');
@endphp

<div class="form-grid">
    <div class="field full">
        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $property->name) }}" required>
    </div>

    <div class="field">
        <label for="price">Price</label>
        <input id="price" name="price" type="number" step="0.01" min="0" value="{{ $propertyPrice }}" required>
    </div>

    <div class="field">
        <label for="storeys">Storeys</label>
        <input id="storeys" name="storeys" type="number" min="1" value="{{ old('storeys', $property->storeys) }}" required>
    </div>

    <div class="field">
        <label for="bedrooms">Bedrooms</label>
        <input id="bedrooms" name="bedrooms" type="number" min="0" value="{{ old('bedrooms', $property->bedrooms) }}" required>
    </div>

    <div class="field">
        <label for="bathrooms">Bathrooms</label>
        <input id="bathrooms" name="bathrooms" type="number" min="0" value="{{ old('bathrooms', $property->bathrooms) }}" required>
    </div>

    <div class="field">
        <label for="garages">Garages</label>
        <input id="garages" name="garages" type="number" min="0" value="{{ old('garages', $property->garages) }}" required>
    </div>

    <div class="field full">
        <label class="checkbox" for="is_test">
            <input
                id="is_test"
                name="is_test"
                type="checkbox"
                value="1"
                {{ old('is_test', $property->is_test) ? 'checked' : '' }}
            >
            <span>Mark as generated test data</span>
        </label>
    </div>
</div>
