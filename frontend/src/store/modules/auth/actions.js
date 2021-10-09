/**
 * APIs
 */
import { createUser as createUserApi, login as loginApi, logout as logoutApi } from '../../../api/auth';
import { updateUser as updateUserApi, user as userApi } from '../../../api/users';

/**
 * Constants
 */
import { ActionTypes } from './action_types';
import { ActionTypes as UsersActionTypes } from '../users/action_types';
import { MutationTypes } from './mutation_types';

/**
 * Exceptions
 */
import DefaultStoreException from '../../exceptions/DefaultStoreException';

export const actions = {

  /**
   * Авторизация пользователя
   *
   * @param context
   * @param payload Параметры для входа
   */
  async [ActionTypes.LOGIN](context, payload) {
    try {
      const user = (await loginApi(payload.email, payload.password)).data.payload.user;

      context.commit(MutationTypes.SET_USER, user);
    } catch (e) {
      throw new DefaultStoreException('Не верный email или пароль');
    }
  },

  /**
   * Выход из системы
   *
   * @param context
   */
  async [ActionTypes.LOGOUT](context) {
    try {
      await logoutApi();

      context.commit(MutationTypes.LOGOUT);
    } catch (e) {
      throw new DefaultStoreException('Что-то пошло не так...');
    }
  },

  /**
   * Получить данные пользователя(зарегистрированного)
   *
   * @param context
   */
  async [ActionTypes.GET_USER](context) {
    try {
      const user = (await userApi()).data.payload.user;

      context.commit(MutationTypes.SET_USER, user);
    } catch (e) {
      throw new DefaultStoreException('Что-то пошло не так...');
    }
  },

  /**
   * Обновить пользователя
   *
   * @param context
   * @param payload
   */
  async [ActionTypes.UPDATE_USER](context, payload) {
    await updateUserApi(payload);

    await context.dispatch(UsersActionTypes.USERS_WITH_ROLES_AND_PERMISSIONS);
  },

  /**
   * Создать пользователя
   *
   * @param context
   * @param payload
   */
  async [ActionTypes.CREATE_USER](context, payload) {
    await createUserApi(payload);

    await context.dispatch(UsersActionTypes.USERS_WITH_ROLES_AND_PERMISSIONS);
  },
};
