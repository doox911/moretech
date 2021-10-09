/**
 * Constants
 */
import { USER_ROLES } from '../../../constants/user';

export const getters = {

  /**
   * Проверка наличия роли у пользователя
   *
   * @param state Состояние
   * @return {Function}
   */
  userRoleCan(state) {
    return role => {
      return state.user?.role
        ? state.user.role.name === role
        : false;
    };
  },

  /**
   * Проверка наличия привилегии у пользователя
   *
   * @param state Состояние
   * @return {Function}
   */
  userPermissionCan(state) {
    return permission => {
      return state.user?.permissions
        ? !!state.user.permissions.find(p => p.name === permission)
        : false;
    };
  },

  /**
   * Проверка наличия у роли пользователя привилегии
   *
   * @param state Состояние
   * @return {Function}
   */
  userRolePermissionCan(state) {
    return permission => {
      return state.user?.role
        ? state.user.role?.permissions
          ? !!state.user.role.permissions.find(p => p.name === permission)
          : false
        : false;
    };
  },

  /**
   * Проверка наличия полномочий у пользователя
   *
   * @param state Состояние
   * @param {any} getters
   * @return {Function}
   */
  userCan(state, getters) {
    return rights => {
      return getters.userRoleCan(rights) ||
        getters.userPermissionCan(rights) ||
        getters.userRolePermissionCan(rights);
    };
  },

  /**
   * Проверка авторизации
   *
   * @param state Состояние
   */
  isAuth(state) {
    return !!state.user?.nickname && !!state.user.email;
  },

  /**
   * Проверка пользователя на супер-администратора
   *
   * @param state Состояние
   */
  isSuperAdmin(state) {
    if (state.user?.role) {
      return state.user.role.name === USER_ROLES.SUPER_ADMIN;
    }

    return false;
  },

  /**
   * Проверка пользователя на администратора
   *
   * @param state Состояние
   */
  isAdmin(state) {
    if (state.user?.role) {
      return state.user.role.name === USER_ROLES.ADMIN;
    }

    return false;
  },

  /**
   * Проверка наличия роли супер-администратора или администратора
   *
   * @param state Состояние
   * @param getters
   */
  isSuperAdminOrAdmin(state, getters) {
    return (getters.isSuperAdmin || getters.isAdmin);
  },

  /**
   * Проверка пользователя на тип прав пользователя
   *
   * @param state Состояние
   */
  isUser(state) {
    if (state.user?.role) {
      return state.user.role.name === USER_ROLES.USER;
    }

    return false;
  },

  /**
   * Пользователь
   *
   * @param state Состояние
   */
  getUser(state) {
    return state.user;
  },

};
