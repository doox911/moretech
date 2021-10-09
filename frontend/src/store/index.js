/**
 * Constants
 */
import { ROOT } from './constants';

/**
 * Helpers
 */
import loadVuexModules from './loadVuexModules';

/**
 * Libraries
 */
import cloneDeep from 'lodash/cloneDeep';

/**
 * Vue
 */
import Vue from 'vue';
import Vuex from 'vuex';

const VuexModules = loadVuexModules();

const InitialVuexModules = cloneDeep(VuexModules);

const store = {
  modules: VuexModules,
  mutations: {

    /**
     * Установить состояния модулей по умолчанию
     *
     * Используем Object.assign для сохранения реактивности
     *
     * @param state Корневое состояние
     */
    [ROOT.ROOT_RESET_MODULES_STATE](state) {
      Object.keys(InitialVuexModules).forEach(module_name => {
        Object.assign(state[module_name], InitialVuexModules[module_name].state);
      });
    },
  },
};

Vue.use(Vuex);

export default new Vuex.Store(store);
