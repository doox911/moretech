/**
 * Constants
 */
import { MutationTypes } from './mutation_types';

export const mutations = {

  /**
   * Установка пользователя
   *
   * @param state Состояние
   * @param payload Пользователь
   */
  [MutationTypes.SET_USER](state, payload) {
    state.user = payload;
  },

  /**
   * @param state Состояние
   */
  [MutationTypes.LOGOUT](state) {
    state.user = null;
  },

};
