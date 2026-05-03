<x-layouts.app title="Dashboard">
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-copy">Signed in as {{ auth()->user()->email }}</p>
        </div>

        <div class="toolbar">
            <a href="{{ route('properties.index') }}" class="button">
                <i class="fa-solid fa-building" aria-hidden="true"></i>
                <span>Server Properties</span>
            </a>
            <a href="{{ route('properties.vue-index') }}" class="button secondary">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Vue Properties</span>
            </a>
        </div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <p class="page-copy">Both the server-rendered and Vue-rendered property list views are available from here.</p>
        </div>
    </section>
</x-layouts.app>
