import Vue from 'vue';
import './plugins/axios';
import App from './App.vue';
import router from './router';
import store from './store';
import vuetify from './plugins/vuetify';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

import './assets/index.scss';
import preloadStore from './store/preloadStore';

Vue.use(VueToast);

Vue.config.productionTip = false;

/**
 * Запуск приложения
 */
async function run() {
  try {
    await window.axios.get('/sanctum/csrf-cookie');
  } catch (e) {
  }

  await preloadStore();

  new Vue({
    router,
    store,
    vuetify,
    render: h => h(App),
  }).$mount('#app');
}

run().then(() => 'Приложение загружено');
