import { getters } from './getters';
import { actions } from './actions';
import { mutations } from './mutations';

export const state = {
  users: [],
};

const namespaced = false;

export const users = {
  namespaced,
  state,
  getters,
  actions,
  mutations,
};
