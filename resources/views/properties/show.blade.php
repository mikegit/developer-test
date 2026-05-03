<x-layouts.app title="{{ $property->name }}">
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $property->name }}</h1>
            <p class="page-copy">Review and maintain the property record.</p>
        </div>

        <div class="toolbar">
            <a href="{{ route('properties.edit', $property) }}" class="button secondary">
                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                <span>Edit</span>
            </a>
            <a href="{{ route('properties.index') }}" class="button secondary">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                <span>Back</span>
            </a>
        </div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <div class="detail-grid">
                <div class="metric">
                    <p class="metric-label">Price</p>
                    <p class="metric-value">${{ number_format((float) $property->price, 2) }}</p>
                </div>
                <div class="metric">
                    <p class="metric-label">Bedrooms</p>
                    <p class="metric-value">{{ $property->bedrooms }}</p>
                </div>
                <div class="metric">
                    <p class="metric-label">Bathrooms</p>
                    <p class="metric-value">{{ $property->bathrooms }}</p>
                </div>
                <div class="metric">
                    <p class="metric-label">Storeys</p>
                    <p class="metric-value">{{ $property->storeys }}</p>
                </div>
                <div class="metric">
                    <p class="metric-label">Garages</p>
                    <p class="metric-value">{{ $property->garages }}</p>
                </div>
                <div class="metric">
                    <p class="metric-label">Record Type</p>
                    <p class="metric-value" style="font-size: 18px;">
                        {{ $property->is_test ? 'Generated Test Data' : 'Source Data' }}
                    </p>
                </div>
            </div>

            <div class="toolbar" style="margin-top: 24px;">
                <form method="post" action="{{ route('properties.destroy', $property) }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="danger" onclick="return confirm('Delete this property?')">
                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        <span>Delete Property</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
