@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue@3.4.38/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://unpkg.com/element-plus"></script>
    <script src="{{ asset('js/utilities/http.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/element-plus/dist/index.css">
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
            <div v-cloak class="element-shell">
                <el-card shadow="never" class="element-card">
                    <el-form label-position="top" @submit.prevent="fetchProperties">
                        <div class="element-grid">
                            <el-form-item label="Name" class="element-span-2">
                                <el-input v-model="filters.name" placeholder="Search partial property name" clearable />
                            </el-form-item>

                            <el-form-item label="Bedrooms">
                                <el-input-number v-model="filters.bedrooms" :min="0" controls-position="right" />
                            </el-form-item>

                            <el-form-item label="Bathrooms">
                                <el-input-number v-model="filters.bathrooms" :min="0" controls-position="right" />
                            </el-form-item>

                            <el-form-item label="Storeys">
                                <el-input-number v-model="filters.storeys" :min="1" controls-position="right" />
                            </el-form-item>

                            <el-form-item label="Garages">
                                <el-input-number v-model="filters.garages" :min="0" controls-position="right" />
                            </el-form-item>

                            <el-form-item label="Min Price">
                                <el-input-number v-model="filters.price_min" :min="0" :precision="2" controls-position="right" />
                            </el-form-item>

                            <el-form-item label="Max Price">
                                <el-input-number v-model="filters.price_max" :min="0" :precision="2" controls-position="right" />
                            </el-form-item>
                        </div>

                        <div class="element-actions">
                            <el-button type="primary" @click="fetchProperties">
                                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                                <span>Search</span>
                            </el-button>
                            <el-button @click="resetFilters">
                                <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                                <span>Reset</span>
                            </el-button>
                        </div>
                    </el-form>
                </el-card>

                <transition name="fade-slide">
                    <el-alert
                        v-if="errorMessage"
                        type="error"
                        :closable="false"
                        :title="errorMessage"
                        class="element-alert"
                    />
                </transition>

                <transition name="fade-slide">
                    <el-card shadow="never" class="element-card">
                        <template v-if="isLoading">
                            <div class="element-loading-row">
                                <span class="loading-state">
                                    <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                                    <span>Loading properties...</span>
                                </span>
                            </div>
                        </template>

                        <template v-else-if="sortedProperties.length === 0">
                            <el-empty description="No properties found." />
                        </template>

                        <template v-else>
                            <div class="table-wrap">
                                <table class="properties-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <button type="button" class="sort-button" @click="setSort('name')">
                                                    <span>Name</span>
                                                    <span class="sort-indicator">{{ sortIndicator('name') }}</span>
                                                </button>
                                            </th>
                                            <th class="numeric">
                                                <button type="button" class="sort-button sort-button-numeric" @click="setSort('price')">
                                                    <span>Price</span>
                                                    <span class="sort-indicator">{{ sortIndicator('price') }}</span>
                                                </button>
                                            </th>
                                            <th class="numeric">
                                                <button type="button" class="sort-button sort-button-numeric" @click="setSort('bedrooms')">
                                                    <span>Bedrooms</span>
                                                    <span class="sort-indicator">{{ sortIndicator('bedrooms') }}</span>
                                                </button>
                                            </th>
                                            <th class="numeric">
                                                <button type="button" class="sort-button sort-button-numeric" @click="setSort('bathrooms')">
                                                    <span>Bathrooms</span>
                                                    <span class="sort-indicator">{{ sortIndicator('bathrooms') }}</span>
                                                </button>
                                            </th>
                                            <th class="numeric">
                                                <button type="button" class="sort-button sort-button-numeric" @click="setSort('storeys')">
                                                    <span>Storeys</span>
                                                    <span class="sort-indicator">{{ sortIndicator('storeys') }}</span>
                                                </button>
                                            </th>
                                            <th class="numeric">
                                                <button type="button" class="sort-button sort-button-numeric" @click="setSort('garages')">
                                                    <span>Garages</span>
                                                    <span class="sort-indicator">{{ sortIndicator('garages') }}</span>
                                                </button>
                                            </th>
                                            <th>
                                                <button type="button" class="sort-button" @click="setSort('is_test')">
                                                    <span>Type</span>
                                                    <span class="sort-indicator">{{ sortIndicator('is_test') }}</span>
                                                </button>
                                            </th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="property in sortedProperties" :key="property.id">
                                            <td>{{ property.name }}</td>
                                            <td class="numeric currency">${{ formatPrice(property.price) }}</td>
                                            <td class="numeric">{{ property.bedrooms }}</td>
                                            <td class="numeric">{{ property.bathrooms }}</td>
                                            <td class="numeric">{{ property.storeys }}</td>
                                            <td class="numeric">{{ property.garages }}</td>
                                            <td>
                                                <el-tag :type="property.is_test ? 'primary' : 'info'" effect="plain">
                                                    {{ property.is_test ? 'Test' : 'Source' }}
                                                </el-tag>
                                            </td>
                                            <td>
                                                <div class="element-actions-cell">
                                                    <el-button size="small" @click="window.location.href = showUrl(property.id)">
                                                        <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                                        <span>View</span>
                                                    </el-button>
                                                    <el-button size="small" @click="window.location.href = editUrl(property.id)">
                                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                                        <span>Edit</span>
                                                    </el-button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                    </el-card>
                </transition>
            </div>
        </div>
    @endverbatim

    @push('scriptsEnd')
        <script src="{{ asset('js/property-index-app.js') }}"></script>
    @endpush

    <style>
        .element-shell {
            --app-el-border-radius-base: var(--el-border-radius-base, 4px);
            --app-el-font-size-base: var(--el-font-size-base, 14px);
            --app-el-form-label-font-size: var(--el-form-label-font-size, 14px);
            --app-el-form-label-font-weight: var(--el-form-label-font-weight, 500);
            --app-el-text-color-regular: var(--el-text-color-regular, #606266);
            --app-el-button-font-size: var(--el-button-font-size, 14px);
            --app-el-button-font-weight: var(--el-button-font-weight, 500);
            --app-el-button-padding-vertical: var(--el-button-padding-vertical, 9px);
            --app-el-button-padding-horizontal: var(--el-button-padding-horizontal, 16px);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .element-shell .el-button {
            min-height: auto;
            padding: var(--app-el-button-padding-vertical) var(--app-el-button-padding-horizontal);
            border-radius: var(--app-el-border-radius-base);
            font-size: var(--app-el-button-font-size);
            font-weight: var(--app-el-button-font-weight);
        }

        .element-shell .el-form-item__label {
            font-size: var(--app-el-form-label-font-size);
            font-weight: var(--app-el-form-label-font-weight);
            color: var(--app-el-text-color-regular);
            line-height: 1.4;
        }

        .element-shell .el-input__wrapper,
        .element-shell .el-textarea__inner {
            min-height: auto;
            border-radius: var(--app-el-border-radius-base);
            font-size: var(--app-el-font-size-base);
        }

        .element-shell .el-input__inner {
            min-height: auto;
            padding: 0;
            border: 0;
            font-size: inherit;
        }

        .element-shell .el-input-number {
            max-width: 100%;
        }

        .element-card {
            border-radius: 8px;
        }

        .element-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px 16px;
        }

        .element-span-2 {
            grid-column: span 2;
        }

        .element-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .element-actions-cell {
            display: flex;
            gap: 8px;
            flex-wrap: nowrap;
            justify-content: flex-start;
            align-items: center;
            white-space: nowrap;
        }

        .element-alert {
            margin: 0;
        }

        .element-loading-row {
            min-height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .properties-table {
            width: 100%;
            border-collapse: collapse;
        }

        .properties-table th,
        .properties-table td {
            vertical-align: middle;
        }

        .sort-button {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            width: 100%;
            padding: 0;
            border: 0;
            background: transparent;
            color: inherit;
            font: inherit;
            text-align: left;
            cursor: pointer;
        }

        .sort-button-numeric {
            justify-content: flex-end;
        }

        .sort-indicator {
            min-width: 12px;
            color: #9ca3af;
            font-size: 12px;
            line-height: 1;
        }

        .element-shell .el-input-number,
        .element-shell .el-input {
            width: 100%;
        }

        .element-shell .el-button + .el-button {
            margin-left: 0;
        }

        .element-actions-cell .el-button {
            flex: 0 0 auto;
            white-space: nowrap;
        }

        @media (max-width: 960px) {
            .element-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .element-span-2 {
                grid-column: span 2;
            }
        }

        @media (max-width: 640px) {
            .element-grid {
                grid-template-columns: 1fr;
            }

            .element-span-2 {
                grid-column: span 1;
            }
        }
    </style>
</x-layouts.app>
