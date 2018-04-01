import * as api from '~/plugins/Http/api/channel';

export default {

    async followed() {
        try {
            const response = await api.followed();
            return response.data.data;
        } catch (e) {
            throw new Error('Не удалось загрузить список каналов.');
        }
    },

    async videos(id, params) {
        try {
            const response = await api.videos(id, params);

            return [response.data.data, response.data.meta];
        } catch (e) {
            throw new Error('Не удалось загрузить список видео канала.');
        }
    },

    async show(id) {
        try {
            const response = await api.show(id);

            return response.data.data;
        } catch (e) {
            throw new Error('Не удалось загрузить канал.');
        }
    },

    async metrics(id) {
        try {
            const response = await api.metrics(id);

            return response.data;
        } catch (e) {
            throw new Error('Не удалось загрузить метрику канала.');
        }
    },

    async report(id) {
        try {
            const response = await api.report(id);

            return response.data;
        } catch (e) {
            throw new Error('Не удалось отправить жалобу на канал.');
        }
    }
}