import Vue from 'vue';
import {mapGetters} from 'vuex';

const User = {
    install (Vue, options) {
        Vue.mixin({
            computed: {
                ...mapGetters({
                    authenticated: 'auth/authenticated',
                    user: 'auth/user',
                    permissions: 'auth/permissions',
                })
            },
            methods: {
                $can(action) {
                    return _.get(this.permissions, action) === true;
                }
            }
        })
    }
}

Vue.use(User);