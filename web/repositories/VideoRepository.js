import * as videoApi from '~/plugins/Http/api/video';

export default {

    async list(params) {
        try {
            const response = await videoApi.list(params);
            return [response.data.data, response.data.meta];
        } catch (e) {
            throw new Error('Не удалось загрузить список видео.');
        }
    },

    async show(id, include = []) {
        try {
            const response = await videoApi.show(id, include);
            return response.data.data;
        } catch (e) {
            throw new Error('Не удалось загрузить видео.');
        }
    }

}