window.AppHttp = {
    create() {
        const token = document.querySelector('meta[name="csrf-token"]');
        const http = axios.create();

        if (token) {
            http.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }

        http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        return http;
    },
};
