import route from "~/plugins/Http/router/route";
import Vue from 'vue'

export default function ({app}) {
    Vue.prototype.$userRepository = app.$userRepository = {
        async register(data) {
            try {
                const response = await app.$axios.post(route('api.auth.register'), data);

                return response.data.data;
            } catch (e) {
                throw new Error('Новый пользователь не был зарегистрирован.');
            }
        },

        async me() {
            try {
                const response = await app.$axios.get(route('api.auth.me'));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить профиль.');
            }
        },

        async permissions() {
            try {
                const response = await app.$axios.get(route('api.auth.permissions'));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить список прав доступа.');
            }
        },
    }
}