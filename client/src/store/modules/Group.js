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
  getters: {
    getGroup(state, id) {
      return state.groups ? state.groups.find((group) => group.id === id) : null;
    },
  },
  actions: { },
};
