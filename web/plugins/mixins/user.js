import Vue from 'vue';
import {mapGetters} from 'vuex';

const User = {
    install (Vue, options) {
        Vue.mixin({
            computed: {
                ...mapGetters({
                    authenticated: 'auth/authenticated',
                    user: 'auth/user',
                })
            }
        })
    }
}

Vue.use(User);