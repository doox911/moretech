import { MutationTypes } from './mutation_types';

export const mutations = {

  /**
   * Принудительное управление левым меню
   *
   * @param state Состояние
   * @param {boolean} payload Устанавливаемое значение
   */
  [MutationTypes.UPDATE_V_NAVIGATION_DRIVER](state, payload) {
    state.v_navigation_drawer = payload;
  },

  /**
   * Переключение состояния левого меню
   *
   * @param state Состояние
   */
  [MutationTypes.TOGGLE_V_NAVIGATION_DRIVER](state) {
    state.v_navigation_drawer = !state.v_navigation_drawer;
  },

  /**
   * Принудительное управление левым меню
   *
   * @param state Состояние
   * @param {boolean} payload Устанавливаемое значение
   */
  [MutationTypes.UPDATE_USER_V_NAVIGATION_DRIVER](state, payload) {
    state.user_v_navigation_drawer = payload;
  },

  /**
   * Принудительное управление верхней панелью
   *
   * @param state Состояние
   * @param {boolean} payload Устанавливаемое значение
   */
  [MutationTypes.UPDATE_V_APP_BAR](state, payload) {
    state.v_app_bar = payload;
  },

  /**
   * Переключение состояния верхней панели
   *
   * @param state Состояние
   */
  [MutationTypes.TOGGLE_V_APP_BAR](state) {
    state.v_app_bar = !state.v_app_bar;
  },

  /**
   * Принудительное управление глобальным ожиданием
   *
   * @param state Состояние
   * @param {boolean} payload Значение глобального ожидания
   */
  [MutationTypes.UPDATE_GLOBAL_LOADING](state, payload) {
    state.global_loading = payload;
  },

  /**
   * Принудительное управление глобальным ожиданием
   *
   * @param state Состояние
   */
  [MutationTypes.TOGGLE_GLOBAL_LOADING](state) {
    state.global_loading = !state.global_loading;
  },

  /**
   * Принудительное управление глобальным overlay
   *
   * @param state Состояние
   * @param {boolean} payload Значение глобального overlay
   */
  [MutationTypes.UPDATE_V_OVERLAY](state, payload) {
    state.v_overlay = payload;
  },

  /**
   * Принудительное управление system snackbar
   *
   * @param state Состояние
   * @param {boolean} payload Значение снекбара
   */
  [MutationTypes.UPDATE_SYSTEM_SNACKBAR](state, payload) {
    state.system_snackbar = payload;
  },

  /**
   * Переключатель видимости system snackbar
   *
   * @param state Состояние
   */
  [MutationTypes.TOGGLE_SYSTEM_SNACKBAR](state) {
    state.system_snackbar = !state.system_snackbar;
  },

  /**
   * Установить тип показываемого system snackbar
   *
   * @param state Состояние
   * @param {string} payload Тип снекбара
   */
  [MutationTypes.SET_TYPE_SYSTEM_SNACKBAR](state, payload) {
    switch (payload) {
      case 'success':
        state.system_snackbar_type = 'success';
        break;
      case 'error':
        state.system_snackbar_type = 'error';
        break;
      default:
        state.system_snackbar_type = 'success';
        break;
    }
  },

  /**
   * Установить сообщения system snackbar messages
   *
   * @param state Состояние
   * @param {boolean} payload Сообщения для снекбара
   */
  [MutationTypes.SET_SYSTEM_SNACKBAR_MESSAGES](state, payload) {
    state.system_snackbar_messages = [...payload];
  },

  /**
   * Добавить сообщения system snackbar messages
   *
   * @param state Состояние
   * @param {string} payload Сообщение для снекбара
   */
  [MutationTypes.APPEND_SYSTEM_SNACKBAR_MESSAGES](state, payload) {
    state.system_snackbar_messages.push(payload);
  },

  /**
   * Переключатель видимости system snackbar
   *
   * @param state Состояние
   */
  [MutationTypes.CLEAR_SYSTEM_SNACKBAR_MESSAGES](state) {
    state.system_snackbar_messages = [];
  },
};
