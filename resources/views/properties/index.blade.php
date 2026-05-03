<x-layouts.app title="Properties">
    <div class="page-header">
        <div>
            <h1 class="page-title">Properties</h1>
            <p class="page-copy">Server-rendered property listing and search.</p>
        </div>

        <div class="toolbar">
            <a href="{{ route('properties.create') }}" class="button">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                <span>New Property</span>
            </a>
            <a href="{{ route('properties.vue-index') }}" class="button secondary">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Vue View</span>
            </a>
        </div>
    </div>
    <section class="panel">
        <div class="panel-body" style="border-bottom: 1px solid #e5e7eb;">
            <form method="get" action="{{ route('properties.index') }}">
                <div class="form-grid">
                    <div class="field full">
                        <label for="name">Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ $filters['name'] ?? '' }}"
                            placeholder="Search partial property name"
                        >
                    </div>

                    <div class="field">
                        <label for="bedrooms">Bedrooms</label>
                        <input id="bedrooms" name="bedrooms" type="number" min="0" value="{{ $filters['bedrooms'] ?? '' }}">
                    </div>

                    <div class="field">
                        <label for="bathrooms">Bathrooms</label>
                        <input id="bathrooms" name="bathrooms" type="number" min="0" value="{{ $filters['bathrooms'] ?? '' }}">
                    </div>

                    <div class="field">
                        <label for="storeys">Storeys</label>
                        <input id="storeys" name="storeys" type="number" min="1" value="{{ $filters['storeys'] ?? '' }}">
                    </div>

                    <div class="field">
                        <label for="garages">Garages</label>
                        <input id="garages" name="garages" type="number" min="0" value="{{ $filters['garages'] ?? '' }}">
                    </div>

                    <div class="field">
                        <label for="price_min">Min Price</label>
                        <input
                            id="price_min"
                            name="price_min"
                            type="number"
                            step="0.01"
                            min="0"
                            value="{{ $filters['price_min'] ?? '' }}"
                        >
                    </div>

                    <div class="field">
                        <label for="price_max">Max Price</label>
                        <input
                            id="price_max"
                            name="price_max"
                            type="number"
                            step="0.01"
                            min="0"
                            value="{{ $filters['price_max'] ?? '' }}"
                        >
                    </div>
                </div>

                <div class="toolbar" style="margin-top: 24px;">
                    <button type="submit">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        <span>Search</span>
                    </button>

                    <a href="{{ route('properties.index') }}" class="button secondary">
                        <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                        <span>Reset</span>
                    </a>
                </div>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>Storeys</th>
                        <th>Garages</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($properties as $property)
                        <tr>
                            <td>{{ $property->name }}</td>
                            <td>${{ number_format((float) $property->price, 2) }}</td>
                            <td>{{ $property->bedrooms }}</td>
                            <td>{{ $property->bathrooms }}</td>
                            <td>{{ $property->storeys }}</td>
                            <td>{{ $property->garages }}</td>
                            <td>
                                <span class="badge {{ $property->is_test ? 'test' : '' }}">
                                    {{ $property->is_test ? 'Test' : 'Source' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('properties.show', $property) }}" class="button secondary">
                                        <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                        <span>View</span>
                                    </a>
                                    <a href="{{ route('properties.edit', $property) }}" class="button secondary">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                        <span>Edit</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No properties found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $properties->links() }}
        </div>
    </section>
</x-layouts.app>
