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
        }
    }
}