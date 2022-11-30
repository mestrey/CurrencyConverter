import { createRouter, createWebHistory } from 'vue-router';
import { AUTH_SAVE_KEY } from './utils/constants';

import store from './store';

import HomeComponent from './components/HomeComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeComponent,
    },
    {
        path: '/login',
        name: 'login',
        component: LoginComponent,
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterComponent,
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