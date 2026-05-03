(function () {
    const appData = window.appData || {};
    const numericFilterKeys = ['bedrooms', 'bathrooms', 'storeys', 'garages', 'price_min', 'price_max'];
    const numberOrNull = (value) => {
        if (value === '' || value === null || typeof value === 'undefined') {
            return null;
        }

        return Number(value);
    };

    const app = Vue.createApp({
        data() {
            return {
                filters: {
                    name: appData.filters?.name || '',
                    bedrooms: numberOrNull(appData.filters?.bedrooms),
                    bathrooms: numberOrNull(appData.filters?.bathrooms),
                    storeys: numberOrNull(appData.filters?.storeys),
                    garages: numberOrNull(appData.filters?.garages),
                    price_min: numberOrNull(appData.filters?.price_min),
                    price_max: numberOrNull(appData.filters?.price_max),
                },
                properties: [],
                isLoading: false,
                errorMessage: '',
                http: null,
                sortBy: 'name',
                sortDirection: 'asc',
            };
        },

        computed: {
            sortedProperties() {
                const properties = [...this.properties];
                const direction = this.sortDirection === 'asc' ? 1 : -1;
                const sortBy = this.sortBy;

                return properties.sort((left, right) => {
                    let leftValue = left[sortBy];
                    let rightValue = right[sortBy];

                    if (sortBy === 'price') {
                        leftValue = Number(leftValue);
                        rightValue = Number(rightValue);
                    } else if (typeof leftValue === 'boolean') {
                        leftValue = leftValue ? 1 : 0;
                        rightValue = rightValue ? 1 : 0;
                    } else if (typeof leftValue === 'string' && typeof rightValue === 'string') {
                        leftValue = leftValue.toLowerCase();
                        rightValue = rightValue.toLowerCase();
                    }

                    if (leftValue < rightValue) {
                        return -1 * direction;
                    }

                    if (leftValue > rightValue) {
                        return 1 * direction;
                    }

                    return 0;
                });
            },
        },

        mounted() {
            if (!window.AppHttp || typeof window.AppHttp.create !== 'function') {
                this.errorMessage = 'Unable to start the property list.';
                return;
            }

            this.http = window.AppHttp.create();
            this.fetchProperties();
        },

        methods: {
            fetchProperties() {
                if (!this.http) {
                    this.errorMessage = 'Unable to start the property list.';
                    return;
                }

                this.isLoading = true;
                this.errorMessage = '';

                this.http.get(appData.searchUrl, {
                    params: this.activeFilters(),
                }).then((response) => {
                    if (!response.data || response.data.success !== true) {
                        this.errorMessage = 'Unable to load properties.';
                        return;
                    }

                    this.properties = response.data.data.properties || [];
                    this.syncUrl();
                }).catch(() => {
                    this.errorMessage = 'Unable to load properties.';
                }).finally(() => {
                    this.isLoading = false;
                });
            },

            resetFilters() {
                this.filters = {
                    name: '',
                    bedrooms: null,
                    bathrooms: null,
                    storeys: null,
                    garages: null,
                    price_min: null,
                    price_max: null,
                };

                this.fetchProperties();
            },

            activeFilters() {
                const filters = {};

                Object.keys(this.filters).forEach((key) => {
                    if (this.filters[key] !== '' && this.filters[key] !== null) {
                        filters[key] = this.filters[key];
                    }
                });

                return filters;
            },

            syncUrl() {
                const params = new URLSearchParams(this.activeFilters()).toString();
                const url = params ? `${window.location.pathname}?${params}` : window.location.pathname;

                window.history.replaceState({}, '', url);
            },

            formatPrice(price) {
                const value = Number(price);

                return value.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            },

            showUrl(propertyId) {
                return appData.showUrlTemplate.replace('__PROPERTY_ID__', propertyId);
            },

            editUrl(propertyId) {
                return appData.editUrlTemplate.replace('__PROPERTY_ID__', propertyId);
            },

            setSort(column) {
                if (this.sortBy === column) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                    return;
                }

                this.sortBy = column;
                this.sortDirection = 'asc';
            },

            sortIndicator(column) {
                if (this.sortBy !== column) {
                    return '';
                }

                return this.sortDirection === 'asc' ? '▲' : '▼';
            },
        },
    });

    app.use(ElementPlus);
    app.mount('#propertyApp');
}());
