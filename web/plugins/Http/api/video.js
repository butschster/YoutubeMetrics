import axios from 'axios';
import route from '../router/route.js';

/**
 * Список видео с постраничной навигацией
 *
 * @return {AxiosPromise}
 */
export function list(params) {
    return axios.get(route('api.videos'), {params});
}

/**
 * Получение информации о видео
 *
 * @return {AxiosPromise}
 */
export function show(video, include = []) {
    return axios.get(route('api.video.show', {video}), {params: {include}});
}