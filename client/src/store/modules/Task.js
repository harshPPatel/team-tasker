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
      state.tasks.forEach((task) => {
        if (task.id === value.id) {
          /* eslint-disable no-param-reassign */
          task.task = value.task;
          task.description = value.description;
          task.dueDate = value.dueDate ? value.duedate : null;
          task.isDone = value.isDone;
          task.updatedAt = value.updatedAt;
          /* eslint-enable no-param-reassign */
        }
      });
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
