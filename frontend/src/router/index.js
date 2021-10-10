import Vue from 'vue';
import VueRouter from 'vue-router';
import Auth from './auth';

/**
 * Store
 */
import store from '../store';
import { MutationTypes } from '../store/modules/application/mutation_types';

Vue.use(VueRouter);

const routes = [
  ...Auth,
  {
    path: '/',
    name: 'Constructor',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../components/Constructor.vue'),
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {

  /**
   * Если доступ к компоненту только для зарегистрированных пользователей
   */
  if (to.matched.some(record => record.meta.auth)) {

    /**
     * Если доступ к компоненту только для зарегистрированных пользователей
     */
    if (store.getters.isAuth) {

      if (!store.getters.isVisibleVAppBar) {

        /**
         * Показываем верхнюю панель
         */
        store.commit(MutationTypes.UPDATE_V_APP_BAR, true);
      }

      if (to.name === 'Login') {
        next({
          name: 'Home',
        });
      }

      next();
    } else {
      /**
       * Скрываем левое меню
       */
      store.commit(MutationTypes.UPDATE_V_NAVIGATION_DRIVER, false);

      /**
       * Скрываем верхнюю панель
       */
      store.commit(MutationTypes.UPDATE_V_APP_BAR, false);

      next({
        name: 'Login',
      });
    }
  } else {
    if (to.name === 'Login') {

      /**
       * Скрываем верхнюю панель
       */
      store.commit(MutationTypes.UPDATE_V_APP_BAR, false);
    }

    if (store.getters.isAuth && to.name === 'Login') {
      next({
        name: 'Home',
      });
    } else {
      next();
    }
  }
});

export default router;
