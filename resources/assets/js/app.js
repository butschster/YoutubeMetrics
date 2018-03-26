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

Vue.component('video-chart', require('./components/Videos/Chart'));
Vue.component('video-comments', require('./components/Videos/Comments'));

Vue.component('comment-chart', require('./components/Comments/CommentChart'));

Vue.component('channels-followed', require('./components/Channels/Followed'));
Vue.component('channel-chart', require('./components/Channels/ChannelChart'));
Vue.component('channel-comments', require('./components/Channels/Comments'));
Vue.component('channel-moderation', require('./components/Channels/Moderation'));
Vue.component('channels-filtered-by-date', require('./components/Channels/FilteredByDate'));

Vue.component('button-report', require('./components/Channels/ReportButton'));
Vue.component('button-moderate', require('./components/Channels/ModerateButton'));

Vue.component('video-clear-cache-button', require('./components/Videos/CacheClearButton'));

const app = new Vue({
    el: '#app'
});

window.Vue = Vue;
