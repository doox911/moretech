export default [
  {
    path: '/login',
    name: 'Login',
    component: () => import(/* webpackChunkName: "auth_login" */ '@/views/auth/Login.vue'),
  },
];
