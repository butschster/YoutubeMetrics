import axios from 'axios';
import route from '../router/route.js';

/**
 * Получение списка каналов, за которыми производится слежение
 *
 * @return {AxiosPromise}
 */
export function followed() {
    return axios.get(route('api.channels.followed'));
}

/**
 * Получение информации о канале
 *
 * @return {AxiosPromise}
 */
export function show(channel) {
    return axios.get(route('api.channel.show', {channel}));
}

/**
 * Получение информации о канале
 *
 * @return {AxiosPromise}
 */
export function videos(channel, params) {
    return axios.get(route('api.channel.videos', {channel}), {params});
}

/**
 * Получение метрики канала
 *
 * @return {AxiosPromise}
 */
export function metrics(channel) {
    return axios.get(route('api.channel.metrics', {channel}));
}

/**
 * Отправка жалобы на канал
 *
 * @return {AxiosPromise}
 */
export function report(channel) {
    return axios.post(route('api.channel.report'), {channel_id: channel});
}