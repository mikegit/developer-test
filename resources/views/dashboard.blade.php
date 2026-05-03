<x-layouts.app title="Dashboard">
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-copy">Signed in as {{ auth()->user()->email }}</p>
        </div>

        <div class="toolbar">
            <a href="{{ route('properties.index') }}" class="button">
                <i class="fa-solid fa-building" aria-hidden="true"></i>
                <span>Open Properties</span>
            </a>
        </div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <p class="page-copy">Property CRUD is now available from the main navigation.</p>
        </div>
    </section>
</x-layouts.app>
