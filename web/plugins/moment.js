import Vue from 'vue';
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
require('moment/locale/ru')

Vue.use(VueMoment, {
    moment,
});