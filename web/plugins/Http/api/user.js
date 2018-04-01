import axios from 'axios';
import route from '../router/route.js';

/**
 * @return {AxiosPromise}
 */
export function me() {
    return axios.get(route('api.me'));
}