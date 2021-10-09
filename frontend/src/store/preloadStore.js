/**
 * Constants
 */
import { ActionTypes as ActionTypesAuth } from './modules/auth/action_types';
import store from './index';

/**
 * Загрузка необходимых данных в Store
 */
export default async function preloadStore() {
  try {
    await store.dispatch(ActionTypesAuth.GET_USER);

  } catch (e) {
  }
};
