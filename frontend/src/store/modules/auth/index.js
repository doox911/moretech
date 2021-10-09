import { getters } from './getters';
import { actions } from './actions';
import { mutations } from './mutations';

export const state = {
  user: null,
};

const namespaced = false;

export const auth = {
  namespaced,
  state,
  getters,
  actions,
  mutations,
};
