import { ActionTypes } from './action_types';
import { MutationTypes } from './mutation_types';

/**
 * APIs
 */
import { usersWithRolesAndPermissions } from '../../../api/users';

/**
 * Exceptions
 */
import DefaultStoreException from '../../exceptions/DefaultStoreException';

export const actions = {

  /**
   * Все пользователи
   *
   * @param context
   */
  async [ActionTypes.USERS_WITH_ROLES_AND_PERMISSIONS](context) {
    try {
      const users = (await usersWithRolesAndPermissions()).data.payload.users;

      context.commit(MutationTypes.SET_USERS, users);
    } catch (e) {
      throw new DefaultStoreException('Что-то пошло не так...');
    }
  },
};
