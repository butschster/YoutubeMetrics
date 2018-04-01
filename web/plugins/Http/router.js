import Vue from 'vue';
import axios from 'axios';
import route from './router/route.js';
import {Ziggy} from './router/routes';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
axios.interceptors.request.use(config => {
    config.baseURL = Ziggy.baseUrl;
    return config;
});

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.mixin({
    methods: {
        route: route
    }
});