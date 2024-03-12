const SuperAdminRoutes = [
    {
        path: '/ca-users',
        name: 'CaUsers',
        meta: {
            requiresAuth: true,
            isSuperAdmin:true
        },
        component: () => import('@/views/CaUser/CaUserIndex.vue')
    },
    
];

export default SuperAdminRoutes;
