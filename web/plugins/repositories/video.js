import route from "~/plugins/Http/router/route";
import Vue from 'vue'

export default function ({app}) {
    Vue.prototype.$videoRepository = app.$videoRepository = {

        async list(params) {
            try {
                const response = await app.$axios.get(route('api.videos'), {params});
                return [response.data.data, response.data.meta];
            } catch (e) {
                throw new Error('Не удалось загрузить список видео.');
            }
        },

        async metrics(video) {
            try {
                const response = await app.$axios.get(route('api.video.metrics', {video}));

                return response.data;
            } catch (e) {
                throw new Error('Не удалось загрузить метрику видео.');
            }
        },

        async tags(video) {
            try {
                const response = await app.$axios.get(route('api.video.tags', {video}));
                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить список тегов для видео.');
            }
        },

        /**
         *
         * @param video
         * @param include
         * @returns {Promise<*>}
         */
        async show(video, include = []) {
            try {
                const response = await app.$axios.get(route('api.video.show', {video}), {params: {include}});
                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить видео.');
            }
        },

        async comments(video) {
            try {
                const response = await app.$axios.get(route('api.video.comments', {video}));
                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить комментарии к видео.');
            }
        },

        async spamComments(video) {
            try {
                const response = await app.$axios.get(route('api.video.comments.spam', {video}));
                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить спам комментарии к видео.');
            }
        },

    }
}