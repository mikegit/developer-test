<x-layouts.app title="Edit Property">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Property</h1>
            <p class="page-copy">Update the selected property details.</p>
        </div>

        <div class="toolbar">
            <a href="{{ route('properties.show', $property) }}" class="button secondary">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                <span>Back</span>
            </a>
        </div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <form method="post" action="{{ route('properties.update', $property) }}">
                @csrf
                @method('put')

                <x-property-form :property="$property" />

                <div class="toolbar" style="margin-top: 24px;">
                    <button type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span>Update Property</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts.app>
