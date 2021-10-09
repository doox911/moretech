/**
 * Constants
 */
import { MutationTypes } from './mutation_types';

export const mutations = {

  /**
   * Добавление пользователей
   *
   * @param state Состояние
   * @param payload Коллекция пользователей из базы данных
   */
  [MutationTypes.SET_USERS](state, payload) {
    state.users = payload;
  },
};
