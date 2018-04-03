import route from "~/plugins/Http/router/route";
import Vue from 'vue'

export default function ({app}) {
    Vue.prototype.$tagRepository = app.$tagRepository = {

        async show(tag) {
            try {
                const response = await app.$axios.get(route('api.tag.show', {tag}));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить информацию по тегу.');
            }
        },

        async videos(tag) {
            try {
                const response = await app.$axios.get(route('api.tag.videos', {tag}));

                return [response.data.data, response.data.meta];
            } catch (e) {
                throw new Error('Не удалось загрузить видео с таким тегом.');
            }
        },
    }
}