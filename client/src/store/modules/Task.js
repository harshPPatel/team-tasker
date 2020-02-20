export default {
  namespaced: true,
  state: {
    tasks: null,
    groupId: null,
  },
  mutations: {
    setTasks(state, value) {
      state.tasks = value;
    },
    setGroupId(state, value) {
      state.groupId = value;
    },
  },
  getters: {
    getTask(state, id) {
      return state.tasks ? state.tasks.find((task) => task.id === id) : null;
    },
    getGroupId(state) {
      return state.groupId;
    },
  },
  actions: { },
};
