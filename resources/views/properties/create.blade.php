<x-layouts.app title="Create Property">
    <div class="page-header">
        <div>
            <h1 class="page-title">Create Property</h1>
            <p class="page-copy">Add a property record to the catalogue.</p>
        </div>

        <div class="toolbar">
            <a href="{{ route('properties.index') }}" class="button secondary">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                <span>Back</span>
            </a>
        </div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <form method="post" action="{{ route('properties.store') }}">
                @csrf

                <x-property-form :property="$property" />

                <div class="toolbar" style="margin-top: 24px;">
                    <button type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        <span>Save Property</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts.app>
