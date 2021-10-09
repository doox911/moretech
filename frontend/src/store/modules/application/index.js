import { getters } from './getters';
import { actions } from './actions';
import { mutations } from './mutations';

export const state = {

  /**
   * Меню слева
   */
  v_navigation_drawer: false,
  user_v_navigation_drawer: false,

  /**
   * Верхняя панель
   */
  v_app_bar: true,

  /**
   * Глобальное ожидание
   */
  global_loading: false,

  /**
   * Глобальный overlay
   */
  v_overlay: false,

  /**
   * Снекбар
   */
  system_snackbar: false,

  /**
   * Сообщения отображаемые в снекбаре
   */
  system_snackbar_messages: [],

  /**
   * Тип снекбара
   */
  system_snackbar_type: 'success',
};

const namespaced = false;

export const application = {
  namespaced,
  state,
  getters,
  actions,
  mutations,
};
