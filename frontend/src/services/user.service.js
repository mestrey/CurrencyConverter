import axios from 'axios';
import authHeader from './auth-header';
import { API_URL } from '../utils/constants';

class UserService {
    getCurrencySymbols() {
        return axios.get(API_URL + 'symbols', { headers: authHeader() });
    }

    getCurrencyRate(from, to) {
        return axios.get(API_URL + `convert/${from}/${to}`, { headers: authHeader() });
    }
}

export default new UserService();