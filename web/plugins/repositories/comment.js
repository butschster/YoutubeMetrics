import route from "~/plugins/Http/router/route";
import Vue from 'vue'

export default function ({app}) {
    Vue.prototype.$commentRepository = app.$commentRepository = {

        async show(comment) {
            try {
                const response = await app.$axios.get(route('api.comment.show', {comment}));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить комментарий.');
            }
        },

        async metrics(comment) {
            try {
                const response = await app.$axios.get(route('api.comment.metrics', {comment}));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить метрику комментария.');
            }
        },
    }
}