export const getters = {

  /**
   * Состояние левого меню
   *
   * @param state Состояние
   */
  getVNavigationDrawer(state) {
    return state.v_navigation_drawer;
  },

  /**
   * Состояние левого меню выбранное пользователем
   *
   * @param state Состояние
   */
  getUserVNavigationDrawer(state) {
    return state.user_v_navigation_drawer;
  },

  /**
   * Состояние верхней панели
   *
   * @param state Состояние
   */
  getVAppBar(state) {
    return state.v_app_bar;
  },

  /**
   * Глобальное ожидание
   *
   * @param state Состояние
   */
  getGlobalLoading(state) {
    return state.global_loading;
  },

  /**
   * Видина ли верхняя панель
   *
   * @param state Состояние
   */
  isVisibleVAppBar(state) {
    return state.v_app_bar;
  },

  /**
   * Состояние глобального overlay
   *
   * @param state Состояние
   */
  getVOverlay(state) {
    return state.v_overlay;
  },

  /**
   * Состояние system snackbar
   *
   * @param state Состояние
   */
  getSystemSnackbar(state) {
    return state.system_snackbar;
  },

  /**
   * Состояние system snackbar type
   *
   * @param state Состояние
   */
  getSystemSnackbarType(state) {
    return state.system_snackbar_type;
  },

  /**
   * Сообщения для system snackbar
   *
   * @param state Состояние
   */
  getSystemSnackbarMessages(state) {
    return state.system_snackbar_messages;
  },
};
