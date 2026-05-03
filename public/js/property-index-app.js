(function () {
    const appData = window.appData || {};

    Vue.createApp({
        data() {
            return {
                filters: {
                    name: appData.filters?.name || '',
                    bedrooms: appData.filters?.bedrooms || '',
                    bathrooms: appData.filters?.bathrooms || '',
                    storeys: appData.filters?.storeys || '',
                    garages: appData.filters?.garages || '',
                    price_min: appData.filters?.price_min || '',
                    price_max: appData.filters?.price_max || '',
                },
                properties: [],
                isLoading: false,
                errorMessage: '',
                http: null,
            };
        },

        mounted() {
            console.log('prop[ertyApp.mounted');

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
                    bedrooms: '',
                    bathrooms: '',
                    storeys: '',
                    garages: '',
                    price_min: '',
                    price_max: '',
                };

                this.fetchProperties();
            },

            activeFilters() {
                const filters = {};

                Object.keys(this.filters).forEach((key) => {
                    if (this.filters[key] !== '') {
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
        },
    }).mount('#propertyApp');
}());
