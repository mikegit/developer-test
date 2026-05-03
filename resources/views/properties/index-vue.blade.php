
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue@3.4.38/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="{{ asset('js/utilities/http.js') }}"></script>
@endpush


<x-layouts.app title="Properties Vue">
    <div class="page-header">
        <div>
            <h1 class="page-title">Properties Vue</h1>
            <p class="page-copy">Client-rendered property listing and search.</p>
        </div>

        <div class="toolbar">
            <a href="{{ route('properties.create') }}" class="button">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                <span>New Property</span>
            </a>
            <a href="{{ route('properties.index') }}" class="button secondary">
                <i class="fa-solid fa-table" aria-hidden="true"></i>
                <span>Server View</span>
            </a>
        </div>
    </div>

    <script>
        window.appData = @json($appData);
    </script>
    @verbatim
        <div id="propertyApp">
            <section class="panel" v-cloak>
                <div class="panel-body">
                    Loading property list...
                </div>
            </section>
            <section class="panel">
                <div class="panel-body" style="border-bottom: 1px solid #e5e7eb;">
                    <form @submit.prevent="fetchProperties">
                        <div class="form-grid">
                            <div class="field full">
                                <label for="name">Name</label>
                                <input
                                    id="name"
                                    v-model="filters.name"
                                    type="text"
                                    placeholder="Search partial property name"
                                >
                            </div>

                            <div class="field">
                                <label for="bedrooms">Bedrooms</label>
                                <input id="bedrooms" v-model="filters.bedrooms" type="number" min="0">
                            </div>

                            <div class="field">
                                <label for="bathrooms">Bathrooms</label>
                                <input id="bathrooms" v-model="filters.bathrooms" type="number" min="0">
                            </div>

                            <div class="field">
                                <label for="storeys">Storeys</label>
                                <input id="storeys" v-model="filters.storeys" type="number" min="1">
                            </div>

                            <div class="field">
                                <label for="garages">Garages</label>
                                <input id="garages" v-model="filters.garages" type="number" min="0">
                            </div>

                            <div class="field">
                                <label for="price_min">Min Price</label>
                                <input id="price_min" v-model="filters.price_min" type="number" step="0.01" min="0">
                            </div>

                            <div class="field">
                                <label for="price_max">Max Price</label>
                                <input id="price_max" v-model="filters.price_max" type="number" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="toolbar" style="margin-top: 24px;">
                            <button type="submit">
                                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                                <span>Search</span>
                            </button>

                            <button type="button" class="secondary" @click="resetFilters">
                                <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                                <span>Reset</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div v-if="errorMessage" class="errors" style="margin: 16px;">
                    {{ errorMessage }}
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
                        <tr v-if="isLoading">
                            <td colspan="8">Loading properties...</td>
                        </tr>
                        <tr v-else-if="properties.length === 0">
                            <td colspan="8">No properties found.</td>
                        </tr>
                        <tr v-for="property in properties" :key="property.id">
                            <td>{{ property.name }}</td>
                            <td>${{ formatPrice(property.price) }}</td>
                            <td>{{ property.bedrooms }}</td>
                            <td>{{ property.bathrooms }}</td>
                            <td>{{ property.storeys }}</td>
                            <td>{{ property.garages }}</td>
                            <td>
                                    <span class="badge" :class="{ test: property.is_test }">
                                        {{ property.is_test ? 'Test' : 'Source' }}
                                    </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a :href="showUrl(property.id)" class="button secondary">
                                        <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                        <span>View</span>
                                    </a>
                                    <a :href="editUrl(property.id)" class="button secondary">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                        <span>Edit</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    @endverbatim

    @push('scriptsEnd')
        <script src="{{ asset('js/property-index-app.js') }}"></script>
    @endpush

</x-layouts.app>

