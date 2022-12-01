import { createRouter, createWebHistory } from 'vue-router';
import { AUTH_SAVE_KEY } from './utils/constants';

import store from './store';

import HomeForm from './components/HomeForm.vue';
import LoginForm from './components/LoginForm.vue';
import RegisterForm from './components/RegisterForm.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeForm,
    },
    {
        path: '/login',
        name: 'login',
        component: LoginForm,
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterForm,
    },
    {
        path: '/logout',
        name: 'logout',
        component: {
            beforeRouteEnter(_to, _from, next) {
                store.dispatch('auth/logout');
                next('/login');
            }
        }
    },
    {
        // path: "*",
        // component: PageNotFound
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, _from, next) => {
    const publicPages = ['/login', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem(AUTH_SAVE_KEY);

    if (authRequired && !loggedIn) {
        next('/login');
    } else {
        next();
    }
});

export default router;