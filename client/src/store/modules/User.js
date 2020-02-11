export default {
  namespaced: true,
  state: {
    username: '',
    isLoggedIn: false,
    theme: 0,
  },
  mutations: {
    loginUser: (state, value) => {
      state.username = value.username.toString();
      state.isLoggedIn = true;
      state.theme = value.theme;
    },
    updateUsername: (state, value) => {
      state.username = value;
    },
    updateIsLoggedIn: (state, value) => {
      state.isLoggedIn = value;
    },
  },
  getters: { },
  actions: {
    logoutUser: ({ commit }) => {
      commit('updateUsername', '');
      commit('updateIsLoggedIn', false);
    },
  },
};
