import route from "~/plugins/Http/router/route";
import Vue from 'vue'

export default function ({app}) {
    Vue.prototype.$channelRepository = app.$channelRepository = {
        async followed() {
            try {
                const response = await app.$axios.get(route('api.channels.followed'));
                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить список каналов.');
            }
        },

        async videos(channel, params) {
            try {
                const response = await app.$axios.get(route('api.channel.videos', {channel}), {params});

                return [response.data.data, response.data.meta];
            } catch (e) {
                throw new Error('Не удалось загрузить список видео канала.');
            }
        },

        async show(channel) {
            try {
                const response = await app.$axios.get(route('api.channel.show', {channel}));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить канал.');
            }
        },

        async metrics(channel) {
            try {
                const response = await app.$axios.get(route('api.channel.metrics', {channel}));

                return response.data;
            } catch (e) {
                throw new Error('Не удалось загрузить метрику канала.');
            }
        },

        async report(channel) {
            try {
                const response = await app.$axios.post(route('api.channel.report'), {channel_id: channel});

                return response.data;
            } catch (e) {
                throw new Error('Не удалось отправить жалобу на канал.');
            }
        },

        async moderate(channel, status) {
            try {
                const response = await app.$axios.post(route('api.channel.moderate', {channel}), {status});

                return response.data;
            } catch (e) {
                throw new Error(e.message);
            }
        },

        async verify(channel) {
            return this.moderate(channel, 'verified');
        },

        async bot(channel) {
            return this.moderate(channel, 'bot');
        },

        async reported() {
            try {
                const response = await app.$axios.get(route('api.channels.reported'));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось получить список каналов имеющих жалобы.');
            }
        },

        async comments(channel) {
            try {
                const response = await app.$axios.get(route('api.channel.comments', {channel}));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить список комментариев канала.');
            }
        },

        async spamComments(channel) {
            try {
                const response = await app.$axios.get(route('api.channel.comments.spam', {channel}));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить список спам комментариев канала.');
            }
        },

        async reporters(channel) {
            try {
                const response = await app.$axios.get(route('api.channel.reporters', {channel}));

                return response.data.data;
            } catch (e) {
                throw new Error('Не удалось загрузить список жалоб на канал.');
            }
        },

    }
}