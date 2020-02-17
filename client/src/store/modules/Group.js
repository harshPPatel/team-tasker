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
    setTasks(state, value) {
      const group = state.groups.find((grp) => grp.id === value.id);
      group.tasks = value.tasks;
    },
  },
  getters: {
    getGroup(state, id) {
      return state.groups ? state.groups.find((group) => group.id === id) : null;
    },
  },
  actions: { },
};
