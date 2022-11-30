import axios from 'axios';
import { API_URL, AUTH_SAVE_KEY } from '../utils/constants';

class AuthService {
    login(user) {
        return axios
            .post(API_URL + 'login', {
                email: user.email,
                password: user.password
            })
            .then(response => {
                if (response.data.data.token) {
                    localStorage.setItem(AUTH_SAVE_KEY, JSON.stringify(response.data));
                }

                return response.data;
            });
    }

    logout() {
        localStorage.removeItem(AUTH_SAVE_KEY);
    }

    register(user) {
        return axios
            .post(API_URL + 'register', {
                name: user.name,
                email: user.email,
                password: user.password,
            })
            .then(response => {
                if (response.data.data.token) {
                    localStorage.setItem(AUTH_SAVE_KEY, JSON.stringify(response.data));
                }

                return response.data;
            });
    }
}

export default new AuthService();