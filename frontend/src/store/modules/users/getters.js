export const getters = {

  /**
   * Пользователи
   *
   * @param state Состояние
   */
  getUsers(state) {
    return state.users;
  },

  /**
   * Пользователь по уникальному идентификатору
   *
   * @param state Состояние
   */
  getUserById(state) {
    return id => state.users.find(user => user.id === id);
  },
};
