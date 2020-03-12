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
    setTask(state, value) {
      const index = state.tasks.indexOf(value);
      if (index) {
        state.tasks[index] = { ...value };
      }
    },
    setGroupId(state, value) {
      state.groupId = value;
    },
  },
  getters: {
    getTask(state, id) {
      return state.tasks ? state.tasks.find((task) => task.id === id) : null;
    },
    getTasks(state) {
      return state.tasks;
    },
    getGroupId(state) {
      return state.groupId;
    },
  },
  actions: { },
};
