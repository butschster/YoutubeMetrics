import Vue from 'vue';
import route from './router/route.js';

Vue.mixin({
    methods: {
        route: route
    }
});