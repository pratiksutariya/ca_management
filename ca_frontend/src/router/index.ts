import { createRouter, createWebHistory } from 'vue-router';
import SuperAdminRoutes from './Modules/SuperAdminRoutes';
import store from '@/store';

export const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/:pathMatch(.*)*',
            component: () => import('@/views/pages/Error404.vue')
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('@/views/auth/Login.vue'),
            meta: {
                requiresAuth: false
            }
        },
        {
            path: '/signup',
            name: 'SignUp',
            component: () => import('@/views/auth/Register.vue'),
            meta: {
                requiresAuth: false
            }
        },
        {
            path: '/main',
            meta: {
                requiresAuth: true
            },
            redirect: '/main',
            component: () => import('@/layouts/full/FullLayout.vue'),
            children: [
                {
                    name: 'Dashboard',
                    path: '/',
                    component: () => import('@/views/dashboard/index.vue')
                },
                ...SuperAdminRoutes,
                {
                    name: 'Starter',
                    path: '/sample-page',
                    component: () => import('@/views/pages/SamplePage.vue')
                }
            ]
        }
    ]
});

router.beforeEach(async (to, from, next) => {
    const isLoggedIn = store.state?.auth.authenticated;
    const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
    const isSuperAdmin = to.matched.some((record) => record.meta?.isSuperAdmin);
    const isAdmin = to.matched.some((record) => record.meta?.isAdmin);
    const isUser = to.matched.some((record) => record.meta?.isUser);
    let user = store.state.auth.user;
    const { path, name, params } = to;
    if (isLoggedIn && ['login', 'forgotPassword', 'forgotView'].includes(name)) {
        return next('/');
    } else if (requiresAuth && isLoggedIn && isSuperAdmin && user.role != 'super-admin') {
        return next('/login');
    } else if (requiresAuth && isLoggedIn && isAdmin && user.role != 'ca-admin') {
        return next('/login');
    } else if (requiresAuth && isLoggedIn && isUser && user.role != 'user') {
        return next('/login');
    } else if (requiresAuth && !isLoggedIn) {
        return next('/login');
    }
    return next();
});
