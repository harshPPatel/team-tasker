export default {
  namespaced: true,
  state: {
    groups: null,
  },
  mutations: {
    setGroups(state, value) {
      state.groups = value;
    },
    addGroup(state, value) {
      state.groups.unshift(value);
    },
  },
  getters: { },
  actions: { },
};
