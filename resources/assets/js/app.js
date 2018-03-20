require('./bootstrap');

import Vue from 'vue';
import Permissions from './Permissions';
import VueSweetalert2 from 'vue-sweetalert2';

Vue.prototype.$permissions = new Permissions(
    window.app.user,
    window.app.permissions
);

Vue.mixin({
    methods: {
        can(action) {
            return this.$permissions.has(action)
        }
    }
});

Vue.use(VueSweetalert2);
Vue.component('video-chart', require('./components/VideoChart'));
Vue.component('comment-chart', require('./components/CommentChart'));
Vue.component('video-comments', require('./components/VideoComments'));
Vue.component('channel-comments', require('./components/ChannelComments'));
Vue.component('channel-moderation', require('./components/ChannelModeration'));
Vue.component('button-report', require('./components/ReportButton'));

const app = new Vue({
    el: '#app'
});

window.Vue = Vue;
