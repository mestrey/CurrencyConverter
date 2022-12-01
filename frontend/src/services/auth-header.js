import { AUTH_SAVE_KEY } from './../utils/constants';

export default function authHeader() {
    let user = JSON.parse(localStorage.getItem(AUTH_SAVE_KEY));

    if (user && user.data.token) {
        return { Authorization: 'Bearer ' + user.data.token };
    } else {
        return {};
    }
}